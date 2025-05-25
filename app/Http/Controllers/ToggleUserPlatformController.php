<?php

namespace App\Http\Controllers;

use App\Http\Requests\TogglePlatformRequest;
use App\Models\Platform;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ToggleUserPlatformController extends Controller
{
    use AuthorizesRequests;
    function __invoke(TogglePlatformRequest $request)
    {
        $platform = Platform::where('type', $request->platform)->firstOrFail();

        // Check if user has enable this platfrom if yes: detach it, if no : attach it
        if ($platform->isPlatfromEnabled()) {
            $this->authorize('toggle', $platform);
            $platform->user()->detach(auth()->id());
        } else {
            $platform->user()->attach(auth()->id());
        }
    }
}