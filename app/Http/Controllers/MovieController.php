<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function homepage(Request $request)
{
    $query = Movie::query();

    // Pencarian berdasarkan judul
    if ($request->search) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    // Filter berdasarkan kategori
    if ($request->category) {
        $query->where('category_id', $request->category);
    }

    $movies = $query->latest()->paginate(16);
    $categories = Category::all(); // Ambil semua kategori dari database

    return view('homepage', compact('movies', 'categories'));
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
    $user = auth()->user();
    if (!$user || $user->role !== 'admin') {
        // Jika bukan admin, redirect ke homepage dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses.');
    }
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
        'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB for image
    ]);

    // Handle file upload if a new cover image is provided
    if ($request->hasFile('cover_image')) {
        // Delete the old cover image if it exists
        if ($movie->cover_image) {
            Storage::disk('public')->delete($movie->cover_image);
        }
        // Store the new cover image
        $validated['cover_image'] = $this->handleFileUpload($request, 'cover_image');
    }

    // Generate unique slug, especially if the title has changed
    // Pass the current movie's ID to avoid issues if the slug remains the same
    if ($request->title !== $movie->title) { // Only regenerate slug if title changes
        $validated['slug'] = $this->generateUniqueSlug($validated['title'], $movie->id);
    } else {
        $validated['slug'] = $movie->slug; // Keep old slug if title doesn't change
    }


    $movie->update($validated);

    return redirect('/')->with('success', 'Movie berhasil diupdate!');
    // Consider redirecting to the movie's detail page or back to the edit page:
    // return redirect()->route('movies.detail', $movie->id)->with('success', 'Movie berhasil diupdate!');
    // return redirect()->route('movies.edit', $movie->id)->with('success', 'Movie berhasil diupdate!');
}

private function handleFileUpload(Request $request, $fieldName)
{
    if ($request->hasFile($fieldName)) {
        $file = $request->file($fieldName);
        // Sanitize filename (optional, but good practice)
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $sanitizedName = Str::slug($originalName);
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '_' . $sanitizedName . '.' . $extension;
        return $file->storeAs('covers', $filename, 'public'); // Stores in storage/app/public/covers
    }
    return null;
}

private function generateUniqueSlug($title, $id = null)
{
    $slug = Str::slug($title);
    $originalSlug = $slug;
    $count = 1;

    // Check if the slug already exists for a different model
    while (Movie::where('slug', $slug)->when($id, function ($query) use ($id) {
        return $query->where('id', '!=', $id);
    })->exists()) {
        $slug = $originalSlug . '-' . $count++;
    }

    return $slug;
}

public function destroy($id)
{
    if (auth()->user()->role !== 'admin') {
        return redirect('/')->with('error', 'Hanya admin yang dapat menghapus movie.');
    }

    $movie = Movie::findOrFail($id);
    $movie->delete();

    return redirect('/')->with('success', 'Movie berhasil dihapus!');
}

public function restore($id)
{
    if (auth()->user()->role !== 'admin') {
        return redirect('/')->with('error', 'Hanya admin yang dapat restore movie.');
    }

    $movie = Movie::withTrashed()->findOrFail($id);
    $movie->restore();

    return redirect('/')->with('success', 'Movie berhasil dikembalikan!');
}

}