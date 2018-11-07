<?php

Route::group([
    'as' => 'app.',
], function () {

    Route::get('/', function () {
        return view('app.home.index', [
            'newslist' => App\Models\News::take(6)->get(),
            'reviews' => App\Models\Review::take(4)->get(),
            'posts' => App\Models\Post::take(8)->get()
        ]);
    })->name('home');

    Route::resource('news', 'NewsController');
    Route::resource('reviews', 'ReviewsController');
    Route::resource('posts', 'PostsController');
    Route::resource('categories', 'CategoriesController');
    Route::resource('tags', 'TagsController');
});
