<?php

namespace App\Console\Commands;

use App\Jobs\SendNewPostNotification;
use App\Models\Post;
use Illuminate\Console\Command;

class ResendFailedPostNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:resend-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resend notification to subscriber. Which is failed during new post';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $posts = Post::with(['subscribers' => function ($query) {
            $query->wherePivot('is_sent', false);
        }])->get();
        foreach ($posts as $post) {
            SendNewPostNotification::dispatch($post, true);
        }
    }
}
