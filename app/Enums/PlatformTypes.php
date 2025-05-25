<?php

namespace App\Enums;

enum PlatformTypes: string
{
    case INSTAGRAM = 'Instagram';
    case LINKEDIN = 'Linkedin';
    case TWITTER = 'Twitter';



    static function toArray()
    {
        return collect(PlatformTypes::cases())->map(function ($value, $key) {
            return [
                'label' => $value->value,
                'value' => $value->value,
            ];
        });
    }
}