<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Logger;
use App\Core\Session;
use App\Core\Validator;
use App\Core\Database;
use App\Models\User;
use App\Services\Mailer;

final class AuthController extends Controller
{
    public function showLogin(): string
    {
        return $this->view('auth/login');
    }

    public function login(object $request): string
    {
        $errors = Validator::validate($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if ($errors) {
            return $this->view('auth/login', ['errors' => $errors]);
        }

        $user = (new User())->findByEmail((string) $request->input('email'));
        if (!$user || !password_verify((string) $request->input('password'), (string) $user['password'])) {
            Logger::error('Invalid login attempt', ['email' => $request->input('email')]);
            return $this->view('auth/login', ['errors' => ['email' => ['Invalid credentials.']]]);
        }

        if (empty($user['email_verified_at'])) {
            return $this->view('auth/login', ['errors' => ['email' => ['Please verify your email address first.']]]);
        }

        Auth::login($user, (bool) $request->input('remember'));
        redirect('/dashboard');
    }

    public function showRegister(): string
    {
        return $this->view('auth/register');
    }

    public function register(object $request): string
    {
        $errors = Validator::validate($request->all(), [
            'name' => ['required', 'min:3', 'max:120'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if ((new User())->findByEmail((string) $request->input('email'))) {
            $errors['email'][] = 'Email already exists.';
        }

        if ($errors) {
            return $this->view('auth/register', ['errors' => $errors]);
        }

        $token = bin2hex(random_bytes(32));
        (new User())->create([
            'role' => 'customer',
            'name' => trim((string) $request->input('name')),
            'email' => trim((string) $request->input('email')),
            'phone' => null,
            'password' => password_hash((string) $request->input('password'), PASSWORD_DEFAULT),
            'avatar' => null,
            'status' => 'active',
            'email_verified_at' => null,
            'email_verification_token' => $token,
            'last_login_at' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        (new Mailer())->send((string) $request->input('email'), 'Verify your email', '<p>Verify: <a href="' . url('verify-email/' . $token) . '">Click here</a></p>');

        Session::flash('success', 'Registration complete. Check your email to verify your account.');
        return $this->view('auth/login', ['message' => 'Registration successful. Verify your email.']);
    }

    public function showForgot(): string
    {
        return $this->view('auth/forgot');
    }

    public function forgotPassword(object $request): string
    {
        $user = (new User())->findByEmail((string) $request->input('email'));
        if ($user) {
            $token = bin2hex(random_bytes(32));
            (new User())->createPasswordResetToken((int) $user['id'], $token, (string) $user['email']);
            (new Mailer())->send((string) $user['email'], 'Reset your password', '<p>Reset: <a href="' . url('reset-password/' . $token) . '">Reset password</a></p>');
        }

        return $this->view('auth/forgot', ['message' => 'If the email exists, a reset link has been sent.']);
    }

    public function showReset(object $request, string $token): string
    {
        return $this->view('auth/reset', ['token' => $token]);
    }

    public function resetPassword(object $request): string
    {
        $token = (string) $request->input('token');
        $record = (new User())->findByResetToken($token);

        if (!$record) {
            return $this->view('auth/reset', ['errors' => ['token' => ['Invalid or expired reset token.']], 'token' => $token]);
        }

        $errors = Validator::validate($request->all(), [
            'password' => ['required', 'min:8'],
        ]);

        if ($errors) {
            return $this->view('auth/reset', ['token' => $token, 'errors' => $errors]);
        }

        $pdo = Database::connection();
        $stmt = $pdo->prepare('UPDATE users SET password = :password, updated_at = NOW() WHERE id = :id');
        $stmt->execute([
            'password' => password_hash((string) $request->input('password'), PASSWORD_DEFAULT),
            'id' => (int) $record['user_id'],
        ]);

        $delete = $pdo->prepare('DELETE FROM password_resets WHERE token = :token');
        $delete->execute(['token' => hash('sha256', $token)]);

        return $this->view('auth/login', ['message' => 'Password has been reset.']);
    }

    public function verifyEmail(object $request, string $token): string
    {
        $user = (new User())->findByVerificationToken($token);
        if ($user) {
            (new User())->verifyEmail((int) $user['id']);
            return $this->view('auth/login', ['message' => 'Email verified successfully. You can login now.']);
        }

        return $this->view('auth/login', ['errors' => ['email' => ['Invalid verification token.']]]);
    }

    public function logout(object $request): never
    {
        Auth::logout();
        redirect('/');
    }
}