<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    // 대량 할당 - Mass Assignment
    protected $guarded = [];

    // One to Many
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
