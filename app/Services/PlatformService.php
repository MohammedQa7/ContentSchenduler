<?php

namespace App\Services;

use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Support\Facades\Cache;


class PlatformService
{
    function getPlatfroms()
    {
        return $this->getOrCachePlatforms();
    }

    function getEnabledPlatforms()
    {
        return Platform::withWhereHas(
            'user',
            function ($query) {
                return $query->where('user_id', auth()->id());
            }
        )->get();
    }


    private function getOrCachePlatforms()
    {
        return Cache::has('platforms')
            ? Cache::get('platforms')
            : Cache::remember('platforms', now()->addDays(3), function () {
                return PlatformResource::collection(Platform::get());
            });
    }
}