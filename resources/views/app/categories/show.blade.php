@extends('layouts.app')

@section('content')

    <div class="d-flex align-items-center">
        <h1 class="pb-4">{{ $category->title }}</h1>
    </div>

    <div class="col pb-4">
        <h3>Новости</h3>
        <div class="row">
            @php($x = 0)
            @forelse($newslist as $news)
                @if($news->category->title == $category->title)
                    @php($x++)
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
            @empty
                <div class="row">
                    <p>Новостей нет.</p>
                </div>
            @endforelse
        </div>
        @if(!$x)
            <div class="row">
                <p>Новостей данной категории нет.</p>
            </div>
        @elseif($x > 5)
            {{ $newslist->links() }}
        @endif
    </div>

    <div class="col pb-4">
        <h3>Посты</h3>
        <div class="row">
            @php($y = 0)
            @forelse($posts as $post)
                @if($post->category->title == $category->title)
                    @php($y++)
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
            @empty
                <div class="row">
                    <p>Постов нет.</p>
                </div>
            @endforelse
        </div>
        @if(!$y)
            <div class="row">
                <p>Постов данной категории нет.</p>
            </div>
        @elseif($y > 5)
            {{ $posts->links() }}
        @endif
    </div>

@endsection
