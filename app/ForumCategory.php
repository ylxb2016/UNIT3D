<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    protected $guarded = ['id'];

    public function forums()
    {
        return $this->hasMany(Forum::class);
    }

    public function topics()
    {
        return $this->hasManyThrough(ForumTopic::class, Forum::class);
    }
}
