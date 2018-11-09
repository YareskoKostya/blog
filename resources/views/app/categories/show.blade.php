@extends('layouts.app')

@section('content')

    <div class="d-flex align-items-center">
        <h1 class="pb-4">{{ $category->title }}</h1>
    </div>

    <div class="col pb-4">
        @foreach(\App\Models\News::query()->paginate(10) as $news)
            <h3>Новости</h3>
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
                @else
                    <div class="col">
                        <p>Новостей данной категории нет.</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="col">
        @foreach(\App\Models\Post::query()->paginate(10) as $post)
            <h3>Посты</h3>
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
                @else
                    <div class="col">
                        <p>Постов данной категории нет.</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

@endsection
