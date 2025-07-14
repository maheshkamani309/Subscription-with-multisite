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

    public $post;
    public $get_only_not_sent;
    /**
     * Create a new job instance.
     */
    public function __construct(Post $post, $get_only_not_sent = false)
    {
        $this->post = $post;
        $this->get_only_not_sent = $get_only_not_sent;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subscribers = Subscriber::where('website_id', $this->post->website_id)->get();
        if ($this->get_only_not_sent) {
            $subscribers = $this->post->subscribers()
                ->where('website_id', $this->post->website_id)
                ->wherePivot('is_sent', false)
                ->get();
        }
        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewPostNotification($this->post));
                $this->post->subscribers()->syncWithoutDetaching([
                    $subscriber->id => [
                        'is_sent' => true,
                        'sent_at' => now()
                    ]
                ]);
            } catch (\Exception $e) {
                $this->post->subscribers()->syncWithoutDetaching([
                    $subscriber->id => [
                        'is_sent' => false,
                        'sent_at' => null
                    ]
                ]);
            }
        }
    }
}
