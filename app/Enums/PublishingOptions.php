<?php

namespace App\Enums;

enum PublishingOptions: string
{
    case PUBLISH = 'Publish';
    case SCHEDULE = 'Schedule';
    case DRAFT = 'Draft';



    static function toArray()
    {
        return collect(PublishingOptions::cases())->map(function ($value, $key) {
            return [
                'label' => $value->value,
                'value' => $value->value,
            ];
        });
    }
}