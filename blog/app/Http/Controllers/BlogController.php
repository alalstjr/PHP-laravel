<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function show($id)
    {
        $blog = Blog::with(['comments'])->where('id', $id)->firstOrFail();

        return view('blogs.show', compact('blog'));
    }

    public function create()
    {
        return view("blogs.create");
    }

    public function store(Request $request)
    {
        Blog::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->back();
    }
}
