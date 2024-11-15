<?php

namespace App\Http\Controllers;

use App\Models\Post;
// use App\Http\Requests\StorePostRequest;
// use App\Http\Requests\UpdatePostRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;


class PostController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // posts list
        $posts = Post::query()->orderBy('id', 'desc')->get();
        return response()->json([
            'message' => 'success',
            'data' => $posts,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            // 'user_id' => 'nullable',
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $post = $request->user()->posts()->create($fields);

        return response()->json([
            'message' => 'post create success',
            'data' => $post
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json([
            'message' => 'success',
            "data" => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);
        $fields = $request->validate([
            'title' => "required",
            "description" => 'required',
        ]);

        $post->update($fields);

        return response()->json([
            'message' => 'post update success',
            "data" => $post,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize("modify", $post);
        $post->delete();
        return response()->json([
            'message' => 'post delete success',
            'data' => $post,
        ]);
    }
}
