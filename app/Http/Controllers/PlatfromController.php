<?php

namespace App\Http\Controllers;

use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlatfromController extends Controller
{
    function index()
    {
        $platforms = Platform::get();
        $enabled_platfomrs = Platform::withWhereHas(
            'user',
            function ($query) {
                return $query->where('user_id', auth()->id());
            }
        )->get();

        return Inertia::render('PlatformManager', [
            'platforms' => PlatformResource::collection($platforms),
            'enabledPlatforms' => PlatformResource::collection($enabled_platfomrs)
        ]);
    }
}