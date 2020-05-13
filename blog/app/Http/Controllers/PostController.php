<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
    {
        $posts = Post::with(["tags"])->get();

        return view("posts.create", compact('posts'));
    }

    public function store(Request $request)
    {
        $post = $request->user()->posts()->create($request->only(["title"]));

        $tags = explode(',', $request->tags);
        $tags = array_map('trim', $tags);
        $tags = array_filter($tags, 'strlen');

        foreach ($tags as $tag) {
            $tag = Tag::updateOrCreate([
                "name" => $tag
            ]);

            $post->tags()->attach($tag->id);
        }

        return redirect()->back();
    }
}
