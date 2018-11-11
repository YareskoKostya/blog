<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewsController extends Controller
{
    public function __construct()
    {
        if (!in_array(app('router')->currentRouteName(), ['app.reviews.index', 'app.reviews.show']) && !auth()->check()) {
            $this->middleware('auth');
        }
    }

    public function index()
    {
        $reviews = Review::query();

        if (request()->filled('author')) {
            $reviews = $reviews->where('user_id', request()->author);
        }

        return view('app.reviews.index', [
            'reviews' => $reviews->paginate(5),
        ]);
    }

    public function create()
    {
        return view('app.reviews.create');
    }

    public function store()
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $review = Review::create(request()->all());

        if (request()->hasFile('media')) {
            $media = request()->file('media');
            $review->media()->create([
                'path' => 'media/' . $media->store('reviews'),
                'collection' => 'reviews',
                'size' => $media->getClientSize(),
                'extension' => $media->getClientOriginalExtension(),
            ]);
        }
        return redirect()->route('app.reviews.show', $review);
    }

    public function show(Review $review)
    {
        return view('app.reviews.show', compact('review'));
    }

    public function edit(Review $review)
    {
        return view('app.reviews.create', [
            'review' => $review,
        ]);
    }

    public function update(Review $review)
    {
        request()->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $review->fill(request()->all());

        if (request()->hasFile('media')) {
            foreach ($review->media as $media){
                Storage::delete(str_replace('media/', '', $media->path));
            }
            $media = request()->file('media');
            $review->media()->update([
                'path' => 'media/' . $media->store('reviews'),
                'collection' => 'reviews',
                'size' => $media->getClientSize(),
                'extension' => $media->getClientOriginalExtension(),
            ]);
        }

        $review->update();
        return redirect(route('app.reviews.index'));
    }

    public function destroy(Review $review)
    {
        $this->checkUser($review);
        foreach ($review->media as $media){
            Storage::delete(str_replace('media/', '', $media->path));
        }
        $review->media()->delete();
        $review->delete();
        return redirect()->route('app.reviews.index');
    }

    public function addComment(Request $request, Review $review)
    {
        $validated = $request->validate([
            'message' => 'required|min:5',
            'user_id' => 'required'
        ]);

        $comment = $review->comments()->create($validated);

        if (auth()->user()->id === $request->user_id) {
            $comment->update(['approved' => 1]);
        }

        return back();
    }

    private function checkUser(Review $review) {
        if ($review->user_id !== auth()->user()->id) {
            return back();
        }
    }
}
