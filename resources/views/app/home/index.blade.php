@extends('layouts.app')

@section('content')

    <div class="col pb-4">
        <h3>Новости</h3>
        @forelse($newslist as $news)
            <div class="row">
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
            </div>
        @empty
            <div class="col">
                <p>Новости пока не добавлены.</p>
            </div>
        @endforelse
    </div>

    <div class="col pb-4">
        <h3>Посты</h3>
        @forelse($posts as $post)
            <div class="row">
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
            </div>
        @empty
            <div class="col">
                <p>Постов пока нет.</p>
            </div>
        @endforelse
    </div>

    <div class="col">
        <h3>Обзоры</h3>
        @forelse($reviews as $review)
            <div class="row">
                <div class="jumbotron mr-4">
                    <h2>
                        <a href="{{ route('app.reviews.show', $review->getKey()) }}">
                            {{ $review->title }}
                        </a>
                    </h2>

                    @if ($review->description)
                        <p>{{ $review->description }}</p>
                    @else
                        <p>{{ str_limit(strip_tags($review->body), 50) }}</p>
                    @endif

                    <p class="mb-0 my-4">{{ $review->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @empty
            <div class="col">
                <p>Обзоров пока нет.</p>
            </div>
        @endforelse
    </div>
@endsection
