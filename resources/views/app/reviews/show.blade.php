@extends('layouts.app')

@section('content')
    <div class="d-flex align-items-center">
        <h1>{{ $review->title }}</h1>
    </div>

    @foreach ($review->media as $media)
        <label for="media" class="form-group">
            <img src="{{ asset($media->path) }}" alt="">
        </label>
    @endforeach

    @if ($review->description)
        <p class="lead">{{ $review->description }}</p>
    @endif

    {!! $review->body !!}

    @if (auth()->check() && $review->user_id === auth()->user()->id)
        <div class="row mt-5">
            <a href="{{ route('app.reviews.edit', $review->getKey()) }}" class="btn btn-primary mx-4">
                Edit
            </a>
            <form action="{{ route('app.reviews.destroy', $review->getKey()) }}" method="post">
                @csrf
                @method('delete')
                <button onclick="return confirm('Are you sure?')" class=" btn btn-danger">
                    Delete
                </button>
            </form>
        </div>
    @endif

    <p class="mt-4">
        Автор:
        <img src="{{ $review->user->user_avatar }}" class="rounded-circle" width="30" alt="">
        <a href="{{ route('app.reviews.index', ['author' => $review->user]) }}">
            {{ $review->user->name }}
        </a>
    </p>

    <h2 class="mt-5">Комментарии -- {{ $review->comments_count }}</h2>

    @forelse($review->comments as $comment)
        <div class="row">
            <div class="col-auto">
                <p><img src="{{ asset($comment->user->user_avatar) }}" class="rounded-circle" alt="{{ $comment->user->name }}" width="100"></p>
                {{ $comment->user->name }}
            </div>

            <div class="col">
                <p>{!! nl2br($comment->message) !!}</p>
                <p class="text-muted text-right mb-0">
                    {{ $comment->created_at->diffForHumans() }}
                </p>
            </div>
        </div>

        <hr>
    @empty
        <p><em>Комментарии пока не добавлены...</em></p>
    @endforelse

    @auth
        <form action="{{ route('app.reviews.add-comment', $review) }}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="form-group{{ $errors->has('message') ? ' is-invalid' : '' }}">
                <label for="message">Ваше сообщение</label>
                <textarea class="form-control" id="message" name="message" required>{{ old('message') }}</textarea>
                @if($errors->has('message'))
                    <div class="mt-1 text-danger">
                        {{ $errors->first('message') }}
                    </div>
                @endif
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">
                    Оставить комментарий
                </button>
            </div>
        </form>
    @endauth

@endsection
