<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        Comment::create([
            'user_id' => $request->user()->id,
            'blog_id' => $request->blog_id,
            'text' => $request->text,
        ]);

        return redirect()->back();
    }
}
