<?php

namespace App\Rules;

use App\Enums\PostStatus;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ScheduledTimeRequired implements ValidationRule
{
    protected string|null $publishOption;

    public function __construct(string|null $publishOption)
    {

        $this->publishOption = $publishOption;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if ($this->publishOption == PostStatus::SCHEDULED->value && empty($value)) {
            $fail('Scheduled time is required when publishing option is set to scheduled.');

        } else if ($this->publishOption != PostStatus::SCHEDULED->value && !empty($value)) {
            $fail('Scheduled time needs to be empty in order to proceed.');
        }
    }
}