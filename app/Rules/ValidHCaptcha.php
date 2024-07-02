<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class ValidHCaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = [
            'secret' => Config::get('captcha.hcaptcha.secret'),
            'response' => $value,
            'sitekey' => Config::get('captcha.hcaptcha.site_key')
        ];

        $response = Http::asForm()->post("https://api.hcaptcha.com/siteverify", $data);

        if (!$response->json('success')){
            $fail("Invalid CAPTCHA. You need to prove you are human.");
        }
    }
}
