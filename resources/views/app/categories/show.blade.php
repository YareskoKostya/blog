@extends('layouts.app')

@section('content')

    <div class="d-flex align-items-center">
        <h1 class="pb-4">{{ $category->title }}</h1>
    </div>

    <div class="col pb-4">
        <h3>Новости</h3>
        @forelse(\App\Models\News::take(6)->get() as $news)
            <div class="row">
                @if($news->category->title == $category->title)
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
                @endif
            </div>
        @empty
            <div class="col">
                <p>Новостей данной категории нет.</p>
            </div>
        @endforelse
    </div>

    <div class="col pb-4">
        <h3>Посты</h3>
        @forelse(\App\Models\Post::take(6)->get() as $post)
            <div class="row">
                @if($post->category->title == $category->title)
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
                @endif
            </div>
        @empty
            <div class="col">
                <p>Постов данной категории нет.</p>
            </div>
        @endforelse
    </div>

    <div class="col">
        <h3>Обзоры</h3>
        @forelse(\App\Models\Review::take(6)->get() as $review)
            <div class="row">
                @if($review->category->title == $category->title)
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
                @endif
            </div>
        @empty
            <div class="col">
                <p>Обзоров данной категории нет.</p>
            </div>
        @endforelse
    </div>

@endsection
