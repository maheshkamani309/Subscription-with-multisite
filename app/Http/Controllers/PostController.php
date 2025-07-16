<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewPostRequest;
use App\Jobs\SendNewPostNotification;
use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(NewPostRequest $request)
    {
        $post = Post::create($request->all());
        $job_number = 0;
        Subscriber::where('website_id', $post->website_id)
            ->chunk(100, function ($subscribers) use ($post, &$job_number) {
            $delay = now()->addSeconds($job_number * 30); 
            SendNewPostNotification::dispatch($post->id, $subscribers->pluck('id')->toArray())->delay($delay);
            $job_number++;
        });

        return response()->json(['message' => 'Post created successfully', 'post' => $post]);
    }

}
