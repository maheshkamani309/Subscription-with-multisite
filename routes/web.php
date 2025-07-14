<?php

use App\Mail\NewPostNotification;
use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $post = Post::find(20);
    $subscribers = Subscriber::where('website_id', $post->website_id)->get();
        foreach ($subscribers as $subscriber) {
            try {

                Mail::to($subscriber->email)->send(new NewPostNotification($post));
                $post->subscribers()->syncWithoutDetaching([
                    $subscriber->id => [
                        'is_sent' => true,
                        'sent_at' => now()
                    ]
                ]);

            } catch (\Exception $e) {
               $post->subscribers()->syncWithoutDetaching([
                    $subscriber->id => [
                        'is_sent' => false,
                        'sent_at' => null
                    ]
                ]);
            }
        }
});
