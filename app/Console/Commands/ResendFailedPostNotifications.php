<?php

namespace App\Console\Commands;

use App\Jobs\SendNewPostNotification;
use App\Models\Post;
use App\Models\Subscriber;
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
        $job_number = 0;
        foreach ($posts as $post) {
            $post->subscribers()
                ->where('website_id', $post->website_id)
                ->wherePivot('is_sent', false)
                ->chunk(100, function ($subscribers) use ($post, &$job_number) {
                    $delay = now()->addSeconds($job_number * 30); 
                    SendNewPostNotification::dispatch($post->id, $subscribers->pluck('id')->toArray())->delay($delay);
                    $job_number++;
                });
        }
    }
}
