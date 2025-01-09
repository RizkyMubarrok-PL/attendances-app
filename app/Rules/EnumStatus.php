<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnumStatus implements ValidationRule
{
    private const ALLOWED_STATUSES = ['Hadir', 'Izin', 'Alpha'];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, self::ALLOWED_STATUSES)) {
            $fail("The :attribute field must be one of the following: " . implode(', ', self::ALLOWED_STATUSES) . '.');
        }
    }
}
