<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        if (request()->filled('tag')) {
            $posts = $posts->whereHas('tags', function ($q) {
                $q->where('tag_id', request('tag'));
            });
        }

        if (request()->filled('author')) {
            $posts = $posts->where('user_id', request()->author);
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

        if (request()->hasFile('media')) {
            $media = request()->file('media');
            $post->media()->create([
                'path' => 'media/' . $media->store('posts'),
                'collection' => 'posts',
                'size' => $media->getClientSize(),
                'extension' => $media->getClientOriginalExtension(),
            ]);
        }
        return redirect()->route('app.posts.show', $post);
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

        if (request()->hasFile('media')) {
            foreach ($post->media as $media){
                Storage::delete(str_replace('media/', '', $media->path));
            }
            $media = request()->file('media');
            $post->media()->update([
                'path' => 'media/' . $media->store('posts'),
                'collection' => 'posts',
                'size' => $media->getClientSize(),
                'extension' => $media->getClientOriginalExtension(),
            ]);
        }

        $post->update();
        return redirect(route('app.posts.index'));
    }

    public function destroy(Post $post)
    {
        $this->checkUser($post);
        $post->tags()->detach(request('tags'));
        $post->delete();
        return redirect()->route('app.posts.index');
    }

    public function addComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'message' => 'required|min:5',
            'user_id' => 'required'
        ]);

        $comment = $post->comments()->create($validated);

        if (auth()->user()->id === $request->user_id) {
            $comment->update(['approved' => 1]);
        }

        return back();
    }

    private function checkUser(Post $post) {
        if ($post->user_id !== auth()->user()->id) {
            return back();
        }
    }
}
