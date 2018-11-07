<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Tag;

class NewsController extends Controller
{
    public function __construct()
    {
        if (!in_array(app('router')->currentRouteName(), ['app.news.index', 'app.news.show']) && !auth()->check()) {
            $this->middleware('auth');
        }
    }

    public function index()
    {
        $newslist = News::query();

        if (request()->has('tag')) {
            $newslist = $newslist->whereHas('tags', function ($q) {
                $q->where('tag_id', request('tag'));
            });
        }

        return view('app.news.index', [
            'newslist' => $newslist->paginate(10),
        ]);
    }

    public function create()
    {
        return view('app.news.create', [
            'categories' => Category::orderBy('title')->get(),
            'tags' => Tag::orderBy('title')->get(),
        ]);
    }

    public function store()
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $news = News::create(request()->all());

        $news->tags()->attach(request('tags'));

        return redirect()->route('app.news.show', $news);
    }

    public function show(News $news)
    {
        return view('app.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        return view('app.news.create', [
            'categories' => Category::orderBy('title')->get(),
            'tags' => Tag::orderBy('title')->get(),
            'news' => $news,
        ]);
    }

    public function update(News $news)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $news->fill(request()->all());
        $news->tags()->updateExistingPivot('tag_id', request('tags'));
        $news->save();
        return redirect(route('app.news.index'));
    }

    public function destroy(News $news)
    {
        $news->delete();
        $news->tags()->detach(request('tags'));
        return redirect(route('app.news.index'));
    }
}
