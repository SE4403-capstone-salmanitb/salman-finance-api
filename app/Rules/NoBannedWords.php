<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Storage;

class NoBannedWords implements ValidationRule
{
    protected $bannedWords = [];

    public function __construct()
    {
        // Load the banned words from the file
        $filePath = Storage::path('bad-word-list.txt');
        if (file_exists($filePath)) {
            $this->bannedWords = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        }
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->bannedWords as $word) {
            if (stripos($value, $word) !== false) {
                $fail("$attribute mengandung kata yang tidak pantas");
                return;
            }
        }
    }
}
