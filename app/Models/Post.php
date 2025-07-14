<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $fillable = ['website_id', 'title', 'description'];


    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(Subscriber::class)
            ->withPivot('is_sent', 'sent_at')
            ->withTimestamps();
    }

    public function website(): BelongsTo
    {
        return $this->belongsTo(Website::class);
    }
}
