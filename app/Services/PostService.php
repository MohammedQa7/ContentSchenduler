<?php

namespace App\Services;

use App\Enums\PostStatus;
use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;


class PostService
{
    function isScheduledTimeGreaterThanNow($date)
    {
        return $date > now();
    }


    function getPostCount()
    {
        return Post::count();
    }

    function getPublishedPostCount()
    {
        return Post::whereNotNull('published_at')
            ->where('status', PostStatus::PUBLISHED->value)
            ->count();
    }

    function getSchedualedPostCount()
    {

    }
}