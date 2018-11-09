@extends('layouts.app')

@section('content')

    <div class="row">
        @forelse($newslist as $news)
            <div class="jumbotron mr-4">
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

            </div>

        @empty
            <div class="col">
                <p>Новости пока не добавлены.</p>
            </div>
        @endforelse

    </div>

    @auth
        <div class="col">
            <a href="{{ route('app.news.create') }}"
               class="btn btn-primary">
                Добавить новость
            </a>

            <a href="{{ route('app.tags.create') }}"
               class="ml-3 btn btn-secondary">
                Добавить тег
            </a>
        </div>

    @endauth

@endsection
