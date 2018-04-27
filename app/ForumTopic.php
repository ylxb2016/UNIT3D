<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    protected $guarded = ['id'];

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, ForumPost::class);
    }
}
