@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center">
        <h1>{{ $post->title }}</h1>
        <div class="ml-3">
            <a href="{{ route('app.categories.show', $post->category->getKey()) }}">
                {{ $post->category->title }}
            </a>
        </div>
    </div>

    @if ($post->description)
        <p class="lead">{{ $post->description }}</p>
    @endif

    {!! $post->body !!}

    @if ($post->tags->count())
        <p class="mt-5 mb-0">
            @foreach($post->tags as $tag)
                <a href="{{ route('app.posts.index', ['tag' => $tag->getKey()]) }}" class="bg-dark text-white px-2 py-1 mr-2 rounded">
                    {{ $tag->title }}
                </a>
            @endforeach
        </p>
    @endif

    <div class="row mt-5">
        <a href="{{ route('app.posts.edit', $post->getKey()) }}" class="btn btn-primary mx-4">
            Edit
        </a>
        <form action="{{ route('app.posts.destroy', $post->getKey()) }}" method="post">
            @csrf
            @method('delete')
            <button onclick="return confirm('Are you sure?')" class=" btn btn-danger">
                Delete
            </button>
        </form>
    </div>
@endsection
