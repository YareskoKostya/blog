@extends('layouts.app')

@section('content')

    <div class="row">
        @forelse($newslist as $news)

        @empty
            <div class="col">
                <p>Новости пока не добавлены.</p>
                @auth
                    @if (\App\Models\Category::count())
                        <a href="{{ route('app.news.create') }}"
                           class="btn btn-primary">
                            Добавить новость
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
