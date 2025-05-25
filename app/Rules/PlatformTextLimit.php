<?php

namespace App\Rules;

use App\Enums\PlatformTypes;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PlatformTextLimit implements ValidationRule
{
    protected array $platforms;

    public function __construct(array $platforms)
    {
        $this->platforms = $platforms;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $limits = [
            PlatformTypes::TWITTER->value => 280,
            PlatformTypes::INSTAGRAM->value => 2200,
            PlatformTypes::LINKEDIN->value => 3000,
        ];

        foreach ($this->platforms as $platform) {
            if (strlen($value) > $limits[$platform]) {
                $fail("The $attribute may not be greater than {$limits[$platform]} characters for $platform.");
            }
        }

    }
}