<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscriber extends Model
{
    protected $fillable = ['website_id', 'name', 'email'];


    public function posts():BelongsToMany
    {
        return $this->belongsToMany(Post::class)
            ->withPivot('is_sent', 'sent_at')
            ->withTimestamps();
    }
}
