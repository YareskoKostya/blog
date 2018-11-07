@extends('layouts.app')

@section('content')

    <div class="row">
        @forelse($newslist as $news)
            <div class="jumbotron">
                <h2>
                    <a href="{{ route('app.news.show', $news->getKey()) }}">
                        {{ $news->title }}
                    </a>
                </h2>

                @if ($news->description)
                    <p>{{ $news->description }}</p>
                @else
                    <p>{{ str_limit(strip_tags($news->body), 50) }}</p>
                @endif

                <p class="mb-0 my-4">{{ $news->created_at->diffForHumans() }}</p>

                <div class="row">
                    <a href="{{ route('app.news.edit', $news->getKey()) }}" class="btn btn-primary mx-4">
                        Edit
                    </a>
                    <form action="{{ route('app.news.destroy', $news->getKey()) }}" method="post">
                        @method('delete')
                        <button onclick="return confirm('Are you sure?')" class="btn-danger">
                            Delete
                        </button>
                    </form>
                </div>

            </div>

            <div class="col">

                @auth
                    <a href="{{ route('app.news.create') }}"
                       class="btn btn-primary">
                        Добавить новость
                    </a>

                    <a href="{{ route('app.tags.create') }}"
                       class="ml-3 btn btn-secondary">
                        Добавить тег
                    </a>
                @endauth
            </div>
        @empty
            <div class="col">
                <p>Новости пока не добавлены.</p>
                @auth
                    <a href="{{ route('app.news.create') }}"
                       class="btn btn-primary">
                        Добавить новость
                    </a>

                    <a href="{{ route('app.tags.create') }}"
                       class="ml-3 btn btn-secondary">
                        Добавить тег
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

@endsection
