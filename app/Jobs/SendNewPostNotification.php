<?php

namespace App\Jobs;

use App\Mail\NewPostNotification;
use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendNewPostNotification implements ShouldQueue
{
    use Queueable;

    public $post_id;
    public $subscriber_ids;
    /**
     * Create a new job instance.
     */
    public function __construct($post_id, $subscriber_ids,  $get_only_not_sent = false)
    {
        $this->post_id = $post_id;
        $this->subscriber_ids = $subscriber_ids;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $post = Post::find($this->post_id);
        $subscribers = Subscriber::whereIn('id', $this->subscriber_ids)->get();
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
    }
}
