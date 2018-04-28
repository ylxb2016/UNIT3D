<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumTag extends Model
{
    public function topics()
    {
        return $this->belongsToMany(ForumTopic::class, 'forum_tag_forum_topic');
    }
}
