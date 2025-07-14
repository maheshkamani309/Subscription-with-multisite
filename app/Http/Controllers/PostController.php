<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewPostRequest;
use App\Jobs\SendNewPostNotification;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(NewPostRequest $request)
    {
         $post = Post::create($request->all());
         SendNewPostNotification::dispatch($post);
         return response()->json(['message' => 'Post created successfully', 'post' => $post]);
    }

}
