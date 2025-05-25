<?php

namespace App\Http\Controllers;

use App\Actions\AttachPostToPlatforms;
use App\Enums\PostStatus;
use App\Enums\PublishingOptions;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PlatformService;
use App\Services\PostService;
use App\Traits\hasAttachments;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PostController extends Controller
{
    use hasAttachments, AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, PlatformService $platform_service , PostService $post_service)
    {
        $posts = Post::with('platforms', 'user')
            ->Filter([...$request->query()])
            ->withoutGlobalScopes()
            ->paginate(7)
            ->withQueryString();

        return Inertia::render('Posts/Index', [
            'posts' => PostResource::collection($posts),
            'platforms' => $platform_service->getEnabledPlatforms(),
            'publishStatus' => PostStatus::toArray(),
            'filters' => [...$request->query()]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, PlatformService $platform_service)
    {
        // Handling both requests to decide what is the best response.

        // axios response
        if (!$request->hasHeader('X-Inertia')) {
            return response()->json([
                'platforms' => $platform_service->getEnabledPlatforms(),
                'publishedOptions' => PublishingOptions::toArray(),
            ]);
        }

        // interia response
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request, PostService $post_services, AttachPostToPlatforms $action)
    {
        $scheduled_time = $request->scheduledDate ? Carbon::parse($request->scheduledDate) : null;

        // dd($request->validated());
        $publish_status = $post_services->isScheduledTimeGreaterThanNow($scheduled_time)
            ? ucfirst($request->publishOption)
            : PostStatus::PUBLISHED->value;


        // Move image to new path.
        $request->image = $this->moveToNewPath($request->image);


        try {
            // Creating Post
            $post = Post::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'content' => $request->content,
                'image_url' => $request->image,
                'scheduled_time' => $scheduled_time,
                'published_at' => !$post_services->isScheduledTimeGreaterThanNow($scheduled_time)
                ? now()
                : null,
                'status' => $publish_status,
                'tags' => $request->tags,
            ]);

            // Attaching Post to mulitple platform for cross posting at the same time.
            $action->handle($post, $request->platforms, $publish_status);


            // The data will be reflected in the database only if both the post and its associated platforms are successfully created.
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post, Request $request)
    {
        $post->load('platforms');
        // Handling both requests to decide what is the best response.

        // axios response
        if (!$request->hasHeader('X-Inertia')) {
            return response()->json([
                'post' => new PostResource($post),
            ]);
        }

        // interia response
        return Inertia::render('Posts/Index', [
            'post' => new PostResource($post),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
    }
}