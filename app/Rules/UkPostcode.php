<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UkPostcode implements ValidationRule
{
    /**
     * Official-style UK postcode pattern (includes GIR 0AA).
     */
    public const PATTERN = '/^(GIR\s?0AA|[A-Z]{1,2}\d[A-Z\d]?\s?\d[A-Z]{2})$/i';

    /**
     * HTML pattern attribute (no delimiters / flags).
     */
    public const HTML_PATTERN = '([Gg][Ii][Rr] ?0[Aa]{2})|((([A-Za-z][0-9]{1,2})|(([A-Za-z][A-Ha-hJ-Yj-y][0-9]{1,2})|(([A-Za-z][0-9][A-Za-z])|([A-Za-z][A-Ha-hJ-Yj-y][0-9][A-Za-z]?)))) ?[0-9][A-Za-z]{2})';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! self::isValid($value)) {
            $fail('Enter a valid UK postcode (e.g. SW1A 1AA).');
        }
    }

    public static function isValid(?string $value): bool
    {
        if ($value === null || trim($value) === '') {
            return false;
        }

        return (bool) preg_match(self::PATTERN, self::normalize($value));
    }

    /**
     * Uppercase and insert a single space before the inward code when possible.
     */
    public static function normalize(string $value): string
    {
        $compact = strtoupper(preg_replace('/\s+/', '', trim($value)) ?? '');

        if (strlen($compact) > 3) {
            return substr($compact, 0, -3).' '.substr($compact, -3);
        }

        return $compact;
    }
}
