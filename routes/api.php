<?php

use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiPostController;
use App\Http\Controllers\Api\CommandController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

// Public API Routes (GET)
Route::apiResource('/posts', ApiPostController::class, ['only' => ['index', 'show']]);
Route::apiResource('/categories', ApiCategoryController::class, ['only' => ['index', 'show']]);
Route::get('run-command', [CommandController::class, 'runCommand'])->middleware('DebugModeOnly');

// POST REST API Endpoint with Data Validation
Route::post('/posts', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'title'       => 'required|string|min:5|max:255',
        'content'     => 'required|string|min:10',
        'category_id' => 'required|integer|exists:categories,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => 'error',
            'message' => 'Validation failed',
            'errors'  => $validator->errors(),
        ], 422);
    }

    $post = new Post();
    $post->user_id     = 1;
    $post->category_id = $request->category_id;
    $post->title       = $request->title;
    $post->slug        = Str::slug($request->title) . '-' . rand(100, 999);
    $post->content     = $request->content;
    $post->status      = true;
    $post->save();

    return response()->json([
        'status'  => 'success',
        'message' => 'Post created successfully via REST API',
        'data'    => $post,
    ], 201);
});