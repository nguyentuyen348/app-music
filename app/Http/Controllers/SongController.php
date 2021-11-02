<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('backend.books.add', compact('categories'));
    }

    public function store(Request $request)
    {
        $song = new Song();
        $song->name = $request->name;
        $song->description = $request->description;
        $song->author = $request->author;
        $song->album = $request->album;
        $song->category_id = $request->category_id;
        $song->user_id = $request->user_id;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('images', 'public');
            $song->image = $path;
        }
        $song->save();
    }

}
