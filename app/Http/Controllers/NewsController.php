<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if (request()->filled('tag')) {
            $newslist = $newslist->whereHas('tags', function ($q) {
                $q->where('tag_id', request('tag'));
            });
        }

        if (request()->filled('author')) {
            $newslist = $newslist->where('user_id', request()->author);
        }

        return view('app.news.index', [
            'newslist' => $newslist->paginate(5),
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

        if (request()->hasFile('media')) {
            $media = request()->file('media');
            $news->media()->create([
                'path' => 'media/' . $media->store('news'),
                'collection' => 'news',
                'size' => $media->getClientSize(),
                'extension' => $media->getClientOriginalExtension(),
            ]);
        }

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
        $news->tags()->sync(request('tags'));

        if (request()->hasFile('media')) {
            foreach ($news->media as $media){
                Storage::delete(str_replace('media/', '', $media->path));
            }
            $media = request()->file('media');
            $news->media()->update([
                'path' => 'media/' . $media->store('posts'),
                'collection' => 'posts',
                'size' => $media->getClientSize(),
                'extension' => $media->getClientOriginalExtension(),
            ]);
        }

        $news->update();
        return redirect(route('app.news.index'));
    }

    public function destroy(News $news)
    {
        $this->checkUser($news);
        $news->tags()->detach(request('tags'));
        foreach ($news->media as $media){
            Storage::delete(str_replace('media/', '', $media->path));
        }
        $news->media()->delete();
        $news->delete();
        return redirect()->route('app.news.index');
    }

    public function addComment(Request $request, News $news)
    {
        $validated = $request->validate([
            'message' => 'required|min:5',
            'user_id' => 'required'
        ]);

        $comment = $news->comments()->create($validated);

        if ((string)auth()->user()->id === $request->user_id) {
            $comment->update(['approved' => 1]);
        }

        return back();
    }

    private function checkUser(News $news) {
        if ($news->user_id !== auth()->user()->id) {
            return back();
        }
    }
}
