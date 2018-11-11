@extends('layouts.app')

@section('content')
    @php
        $route = route('app.reviews.store');
        $method = 'post';

        if (isset($post)) {
            $route = route('app.reviews.update', $review);
            $method = 'patch';
        }
    @endphp

    <form action="{{ $route }}" method="post" enctype="multipart/form-data">
        @csrf
        @method($method)

        <div class="form-group{{ $errors->has('title') ? ' is-invalid' : '' }}">
            <label for="title">Заголовок</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $review->title ?? old('title') }}" required>
            @if($errors->has('title'))
                <div class="mt-1 text-danger">
                    {{ $errors->first('title') }}
                </div>
            @endif
        </div>

        @isset($review)
            @foreach ($review->media as $media)
                <label for="media" class="form-group">
                    <img src="{{ asset($media->path) }}" alt="">
                </label>
            @endforeach
        @endisset

        <div class="form-group">
            <label>Изображение</label>
            <input type="file" class="form-control" id="media" name="media">
        </div>

        <div class="form-group">
            <label for="description">Краткое описание</label>
            <textarea name="description" id="description" rows="2" class="form-control">{{ $review->description ?? old('description') }}</textarea>
        </div>

        <div class="form-group{{ $errors->has('body') ? ' is-invalid' : '' }}">
            <label for="body">Текст обзора</label>
            <textarea class="form-control" id="body" name="body" rows="4" required>{{ $review->body ?? old('body') }}</textarea>
            @if($errors->has('body'))
                <div class="mt-1 text-danger">
                    {{ $errors->first('body') }}
                </div>
            @endif
        </div>

        <div class="mt-4">
            <button class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection
