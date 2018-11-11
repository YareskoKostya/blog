@extends('layouts.app')

@section('content')

    <div class="row">
        @forelse($reviews as $review)
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
        @empty
            <div class="col">
                <p>Обзоров пока нет.</p>
            </div>
        @endforelse
    </div>

    {{ $reviews->appends(request()->except('page'))->links() }}

    @auth
        <div class="col">
            <a href="{{ route('app.reviews.create') }}"
               class="btn btn-primary">
                Добавить обзор
            </a>
        </div>
    @endauth

@endsection
