<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // 대량 할당 - Mass Assignment
    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
