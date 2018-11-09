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
                @auth
                    @if (\App\Models\Category::count())
                        <a href="{{ route('app.posts.create') }}"
                           class="btn btn-primary">
                            Добавить пост
                        </a>
                    @else
                        Для начала Вам нужно
                        <a href="{{ route('app.categories.create') }}"
                           class="ml-3 btn btn-primary">
                            Создать категорию
                        </a>
                    @endif
                @endauth
            </div>
        @endforelse
    </div>

@endsection
