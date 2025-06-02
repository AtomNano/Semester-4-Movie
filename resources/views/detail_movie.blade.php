@extends('layouts.template')

@section('content')
    <div class="container mt-4">
        <div class="card mb-3 shadow">
            <div class="row g-0">
                <div class="col-md-4">
    @if ($movie->cover_image && file_exists(public_path('storage/' . $movie->cover_image)))
        <img src="{{ asset('storage/' . $movie->cover_image) }}" class="img-fluid rounded-start" alt="{{ $movie->title }}">
    @else
        <img src="https://via.placeholder.com/300x400?text=No+Image" class="img-fluid rounded-start" alt="No Image">
    @endif
</div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h3 class="card-title">{{ $movie->title }}</h3>
                        <p class="card-text">{{ $movie->synopsis }}</p>
                        <p><strong>Actors:</strong> {{ $movie->actors ?? 'N/A' }}</p>
                        <p><strong>Category:</strong> {{ $movie->category->category_name ?? 'Uncategorized' }}</p>
                        <p><strong>Year:</strong> {{ $movie->year }}</p>
                        <a href="{{ url()->previous() }}" class="btn btn-success">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection