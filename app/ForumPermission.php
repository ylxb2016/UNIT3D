<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumPermission extends Model
{
    protected $guarded = ['id'];

    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }
}
