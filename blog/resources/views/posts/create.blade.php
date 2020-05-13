@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Create a Post</h1>

                @foreach($posts as $post)
                    <ul>
                        <li>
                            Title : {{ $post->title }}} <br/>
                            Tags :
                                @foreach($post->tags as $tag)
                                    {{$tag->name}}}
                                @endforeach
                        </li>
                    </ul>
                @endforeach
                <form action="{{ route('posts.store') }}" method="post">
                    @csrf
                    <input type="text" name="title" placeholder="title">
                    <input type="text" name="tags" placeholder="tags">
                    <button>Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection
