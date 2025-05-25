<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Platform;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $published_posts = Post::with('platforms', 'user')->get();

        $schedualed_posts = null;
        if (!is_null($request->query('currentTab')) && $request->query('currentTab') == 'calendar') {
            $schedualed_posts = Post::with('platforms')
                ->withoutGlobalScopes()
                ->whereNull('published_at')
                ->get();
        }


        $grouped_posts = $published_posts->flatMap(function ($post) {
            return $post->platforms->map(function ($platform) use ($post) {
                return [
                    'post' => new PostResource($post),
                    'platform' => $platform->type,
                ];
            });
        })->values();

        return Inertia::render('Dashboard', [
            'posts' => $grouped_posts,
            'schedualedPosts' => $schedualed_posts ? PostResource::collection($schedualed_posts) : null,
            'selectedTab' => $request->query('currentTab'),
        ]);
    }
}