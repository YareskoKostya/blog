<?php

Route::group([
    'as' => 'app.',
], function () {

    Route::get('/', function () {
        return view('app.home.index', [
            'newslist' => App\Models\News::take(5)->get(),
            'reviews' => App\Models\Review::take(5)->get(),
            'posts' => App\Models\Post::take(5)->get()
        ]);
    })->name('home');

    Route::group([
        'as' => 'profile.',
        'prefix' => 'profile',
        'middleware' => ['auth']
    ], function () {
        Route::get('/', 'ProfileController@index')->name('index');
        Route::patch('update', 'ProfileController@update')->name('update');
    });

    Route::resource('news', 'NewsController');
    Route::post('news/{news}/comment', 'NewsController@addComment')->name('news.add-comment');
    Route::resource('reviews', 'ReviewsController');
    Route::post('reviews/{review}/comment', 'ReviewController@addComment')->name('reviews.add-comment');
    Route::resource('posts', 'PostsController');
    Route::post('posts/{post}/comment', 'PostController@addComment')->name('posts.add-comment');
    Route::resource('categories', 'CategoriesController');
    Route::resource('tags', 'TagsController');
});
