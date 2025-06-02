<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function homepage()
    {
        $movies = Movie::latest()->paginate(6);
        return view('homepage', compact('movies'));
    }

    public function detailMovie($id, $slug)
    {
        $movie = Movie::findOrFail($id);
        return view('detail_movie', compact('movie'));
    }

    public function show($id)
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
        $validated['cover_image'] = $this->handleFileUpload($request, 'cover_image');

        // Generate unique slug
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

        Movie::create($validated);

        return redirect('/')->with('success', 'Movie berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $movie = Movie::findOrFail($id);
        $categories = Category::all();
        return view('edit_movie', compact('movie', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $movie = Movie::findOrFail($id);

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
            // Hapus file lama jika ada
            if ($movie->cover_image) {
                Storage::disk('public')->delete($movie->cover_image);
            }
            $validated['cover_image'] = $this->handleFileUpload($request, 'cover_image');
        }

        // Generate unique slug
        $validated['slug'] = $this->generateUniqueSlug($validated['title'], $movie->id);

        $movie->update($validated);

        return redirect('/')->with('success', 'Movie berhasil diupdate!');
    }

    private function handleFileUpload(Request $request, $fieldName)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $filename = time() . '_' . $file->getClientOriginalName();
            return $file->storeAs('covers', $filename, 'public');
        }
        return null;
    }

    private function generateUniqueSlug($title, $id = null)
    {
        $slug = Str::slug($title);
        $count = Movie::where('slug', 'LIKE', "{$slug}%")
            ->when($id, function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })
            ->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}