<?php
declare(strict_types=1);

namespace App\Services;

final class SeoService
{
    public function meta(array $data = []): array
    {
        return [
            'title' => $data['title'] ?? config('seo.default_title'),
            'description' => $data['description'] ?? config('seo.default_description'),
            'keywords' => $data['keywords'] ?? config('seo.default_keywords'),
            'canonical' => $data['canonical'] ?? url(),
        ];
    }
}