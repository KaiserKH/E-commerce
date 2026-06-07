<?php
declare(strict_types=1);

namespace App\Core;

final class Validator
{
    public static function validate(array $input, array $rules): array
    {
        $errors = [];

        foreach ($rules as $field => $fieldRules) {
            $value = $input[$field] ?? null;
            $fieldRules = is_array($fieldRules) ? $fieldRules : explode('|', $fieldRules);

            foreach ($fieldRules as $rule) {
                if ($rule === 'required' && ($value === null || $value === '')) {
                    $errors[$field][] = 'The ' . $field . ' field is required.';
                }

                if ($rule === 'email' && $value && !filter_var((string) $value, FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = 'The ' . $field . ' must be a valid email address.';
                }

                if (str_starts_with((string) $rule, 'min:')) {
                    $min = (int) substr((string) $rule, 4);
                    if (mb_strlen((string) $value) < $min) {
                        $errors[$field][] = 'The ' . $field . ' must be at least ' . $min . ' characters.';
                    }
                }

                if (str_starts_with((string) $rule, 'max:')) {
                    $max = (int) substr((string) $rule, 4);
                    if (mb_strlen((string) $value) > $max) {
                        $errors[$field][] = 'The ' . $field . ' may not be greater than ' . $max . ' characters.';
                    }
                }
            }
        }

        return $errors;
    }
}