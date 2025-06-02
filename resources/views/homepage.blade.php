@extends('layouts.template')

@section('title', 'Latest Movies') {{-- Example of setting a title for the page --}}

@section('content')

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert"> {{-- Changed to alert-success for success messages --}}
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <h1>Latest Movies</h1> {{-- Changed title for clarity --}}

    <div class="row">
        @forelse ($movies as $movie)
        <div class="col-lg-6">
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        @if (filter_var($movie->cover_image, FILTER_VALIDATE_URL))
                            {{-- Jika cover_image adalah URL lengkap --}}
                            <img src="{{ $movie->cover_image }}" class="img-fluid rounded-start" style="height: 100%; object-fit: cover;" alt="{{ $movie->title }}">
                        @elseif ($movie->cover_image)
                            {{-- Jika cover_image adalah path relatif dari database --}}
                            <img src="{{ asset('storage/' . $movie->cover_image) }}" class="img-fluid rounded-start" style="height: 100%; object-fit: cover;" alt="{{ $movie->title }}">
                        @else
                            {{-- Jika tidak ada gambar, gunakan placeholder --}}
                            <img src="https://via.placeholder.com/300x400?text=No+Image" class="img-fluid rounded-start" style="height: 100%; object-fit: cover;" alt="No Image">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <p class="card-text">{{ Str::words($movie->synopsis, 20, '...') }}</p>
                            <a href="{{ route('movies.detail', ['id' => $movie->id]) }}" class="btn text-white bg-success">See More</a>
                            @auth
                                <a href="{{ route('movies.edit', ['id' => $movie->id]) }}" class="btn btn-warning text-white">Edit</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col">
            <p>No movies found.</p>
        </div>
        @endforelse
    </div>
    {{-- Pagination links --}}
    @if ($movies->hasPages())
    <div class="mt-4">
        {{ $movies->links() }}
    </div>
    @endif

@endsection