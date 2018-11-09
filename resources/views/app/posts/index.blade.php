@extends('layouts.app')

@section('content')

    <div class="row">
        @forelse($posts as $post)

        @empty
            <div class="col">
                <p>Постов пока нет.</p>
                @auth
                    @if (\App\Models\Category::count())
                        <a href="{{ route('app.posts.create') }}"
                           class="btn btn-primary">
                            Добавить пост
                        </a>
                    @else
                        Для начала Вам нужно
                        <a href="{{ route('app.categories.create') }}"
                           class="ml-3 btn btn-primary">
                            Создать категорию
                        </a>
                    @endif
                @endauth
            </div>
        @endforelse
    </div>

@endsection
