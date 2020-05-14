@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Post Show Page</h1>
                <p>Post Title : {{ $blog->title }}</p>
            </div>

            <h2>Post Comment List</h2>
            <div>
                @foreach($blog->comments as $comment)
                    <p>{{ $comment->text }}</p>
                @endforeach
            </div>

            <form action="{{ route('comments.store') }}" method="post">
                @csrf
                <input type="text" name="blog_id" value="{{ $blog->id }}">
                <input type="text" name="text" placeholder="text">
                <button>Create</button>
            </form>
        </div>
    </div>
@endsection
