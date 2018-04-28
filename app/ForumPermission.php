<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumPermission extends Model
{
    protected $guarded = ['id'];

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_forum_permission');
    }

}
