<?php

namespace App\Enums;

enum PostStatus: string
{
    case DRAFT = 'Draft';
    case SCHEDULED = 'Scheduled';
    case PUBLISHED = 'Published';



    static function toArray()
    {
        return collect(PostStatus::cases())->map(function ($value, $key) {
            return [
                'label' => $value->value,
                'value' => $value->value,
            ];
        });
    }
}