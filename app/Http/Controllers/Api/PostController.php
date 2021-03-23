<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest as Request;
use App\Http\Resources\v1\PostResource;
use App\Models\Post;
use App\Traits\ApiResponser;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate();
        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->cannot('create', Post::class)) {
            return $this->error("You can't perform this action", Response::HTTP_FORBIDDEN);
        }

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        $response = Post::create($input);
        return new PostResource($response);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (auth()->user()->cannot('update', $post)) {
            return $this->error("This post isn't yours", Response::HTTP_FORBIDDEN);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (auth()->user()->cannot('delete', $post)) {
            return $this->error("This post isn't yours", Response::HTTP_FORBIDDEN);
        }

        $post->delete();
        return response()->json(['message' => 'Post Deleted.'], Response::HTTP_OK);
    }
}
