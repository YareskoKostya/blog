<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {
        if (!in_array(app('router')->currentRouteName(), ['app.posts.index', 'app.posts.show']) && !auth()->check()) {
            $this->middleware('auth');
        }
    }

    public function index()
    {
        $posts = Post::query();

        if (request()->has('tag')) {
            $posts = $posts->whereHas('tags', function ($q) {
                $q->where('tag_id', request('tag'));
            });
        }

        return view('app.posts.index', [
            'posts' => $posts->paginate(10),
        ]);
    }

    public function create()
    {
        return view('app.posts.create', [
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

        $post = Post::create(request()->all());

        $post->tags()->attach(request('tags'));

        return redirect()->route('app.news.show', $post);
    }

    public function show(Post $post)
    {
        return view('app.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('app.posts.create', [
            'categories' => Category::orderBy('title')->get(),
            'tags' => Tag::orderBy('title')->get(),
            'post' => $post,
        ]);
    }

    public function update(Post $post)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post->fill(request()->all());
        $post->tags()->sync(request('tags'));
        $post->save();
        return redirect(route('app.posts.index'));
    }

    public function destroy(Post $post)
    {
        $post->tags()->detach(request('tags'));
        $post->delete();
        return redirect()->route('app.posts.index');
    }
}
