<?php

namespace App\Actions;

use App\Models\Platform;

class AttachPostToPlatforms
{
    function handle($post, $platforms, $publish_status)
    {
        foreach ($platforms as $single_platform) {
            $platform = Platform::where('type', $single_platform)->firstOrFail();
            $post->platforms()->attach($platform->id, [
                'platform_status' => $publish_status
            ]);
        }
    }
}