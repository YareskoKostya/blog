@extends('layouts.app')

@section('content')

    <form action="{{ route('app.tags.store') }}" method="post">
        @csrf

        <div class="form-group{{ $errors->has('title') ? ' is-invalid' : '' }}">
            <label for="title">Название</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $tag->title ?? old('title') }}" required>
            @if($errors->has('title'))
                <div class="mt-1 text-danger">
                    {{ $errors->first('title') }}
                </div>
            @endif
        </div>

        <div class="mt-4">
            <button class="btn btn-primary">Сохранить</button>
        </div>
    </form>
@endsection
