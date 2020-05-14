<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // 대량 할당 - Mass Assignment
    protected $guarded = [];
}
