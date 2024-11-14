<?php

namespace App\Http\Controllers;

use App\Models\Post;
// use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;

class PostController extends Controller
{
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
            'user_id' => 'required',
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $post = Post::create($fields);

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
        $post->delete();
        return response()->json([
            'message' => 'post delete success',
            'data' => $post,
        ]);
    }
}
