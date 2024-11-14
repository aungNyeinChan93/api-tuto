<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('test', function () {
    return 'test';
});

// Route::get("posts", [PostController::class, 'index']);

Route::apiResource('posts', PostController::class);


