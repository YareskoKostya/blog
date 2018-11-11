<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct()
    {
        if (!in_array(app('router')->currentRouteName(), ['app.categories.show']) && !auth()->check()) {
            $this->middleware('auth');
        }
    }

    public function show(Category $category)
    {
        return view('app.categories.show', [
            'newslist' => News::paginate(5),
            'posts' => Post::paginate(5),
            'category' => $category
        ]);
    }
}
