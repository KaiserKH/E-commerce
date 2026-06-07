<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Validator;

final class ContactController extends Controller
{
    public function show(): string
    {
        return $this->view('contact/index');
    }

    public function submit(object $request): string
    {
        $errors = Validator::validate($request->all(), [
            'name' => ['required', 'min:3', 'max:120'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'min:3', 'max:200'],
            'message' => ['required', 'min:10'],
        ]);

        if ($errors) {
            return $this->view('contact/index', ['errors' => $errors]);
        }

        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO contact_messages (name, email, subject, message, status, created_at, updated_at) VALUES (:name, :email, :subject, :message, :status, NOW(), NOW())');
        $stmt->execute([
            'name' => trim((string) $request->input('name')),
            'email' => trim((string) $request->input('email')),
            'subject' => trim((string) $request->input('subject')),
            'message' => trim((string) $request->input('message')),
            'status' => 'new',
        ]);

        return $this->view('contact/index', ['message' => 'Message sent successfully. We will contact you soon.']);
    }
}