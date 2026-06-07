<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Config;

final class Mailer
{
    public function send(string $to, string $subject, string $html): bool
    {
        $headers = [
            'MIME-Version: 1.0',
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . Config::get('mail.from_name') . ' <' . Config::get('mail.from_address') . '>',
        ];

        return mail($to, $subject, $html, implode("\r\n", $headers));
    }
}