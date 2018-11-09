@extends('layouts.app')

@section('content')

    <div class="d-flex align-items-center">
        <h1>{{ $category->title }}</h1>
    </div>

    <div class="row">

        @foreach(\App\Models\News::query()->paginate(10) as $news)

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
        @endforeach
    </div>

@endsection
