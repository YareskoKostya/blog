<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function create()
    {
        return view('app.tags.create');
    }

    public function store()
    {
        request()->validate([
            'title' => 'required'
        ]);

        Tag::create(request()->all());

        return redirect()->route('app.news.index');
    }
}
