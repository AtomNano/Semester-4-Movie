<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    //
    public function homepage(){
        $movies = Movie::latest()->paginate(6);
        return view('homepage', compact('movies'));
    }

    public function detailMovie($id, $slug)
{
    $movie = Movie::findOrFail($id);
    return view('detail_movie', compact('movie'));
}

    public function create()
    {
        $categories = Category::all();
        return view('create_movie', compact('categories'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'synopsis' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'year' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
        'actors' => 'nullable|string',
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle file upload
    if ($request->hasFile('cover_image')) {
        $file = $request->file('cover_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('covers', $filename, 'public');
        $validated['cover_image'] = '/storage/' . $path;
    }

    // Generate slug
    $validated['slug'] = Str::slug($validated['title']);

    \App\Models\Movie::create($validated);

    return redirect('/')->with('success', 'Movie berhasil ditambahkan!');
}
}
