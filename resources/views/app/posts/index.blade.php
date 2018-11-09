@extends('layouts.app')

@section('content')

    <div class="row">
        @forelse($posts as $post)
            <div class="jumbotron mr-4">
                <h2>
                    <a href="{{ route('app.posts.show', $post->getKey()) }}">
                        {{ $post->title }}
                    </a>
                </h2>

                @if ($post->description)
                    <p>{{ $post->description }}</p>
                @else
                    <p>{{ str_limit(strip_tags($post->body), 50) }}</p>
                @endif

                <p class="mb-0 my-4">{{ $post->created_at->diffForHumans() }}</p>

            </div>
        @empty
            <div class="col">
                <p>Постов пока нет.</p>
            </div>
        @endforelse
    </div>

    @auth
        <div class="col">
            <a href="{{ route('app.posts.create') }}"
               class="btn btn-primary">
                Добавить пост
            </a>

            <a href="{{ route('app.tags.create') }}"
               class="ml-3 btn btn-secondary">
                Добавить тег
            </a>
        </div>
    @endauth

@endsection
