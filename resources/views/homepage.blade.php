@extends('layouts.template')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    @if (session('success'))

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    
    @endif
    <h1>Latest Movie</h1>

    

    <div class="row">
        @foreach ($movies as $movie)
        <div class="col-lg-6">
        <div class="card mb-3">
  <div class="row g-0">
    <div class="col-md-4">
    @if (filter_var($movie->cover_image, FILTER_VALIDATE_URL))
        {{-- Jika cover_image adalah URL lengkap --}}
        <img src="{{ $movie->cover_image }}" class="img-fluid rounded-start" alt="{{ $movie->title }}">
    @elseif ($movie->cover_image)
        {{-- Jika cover_image adalah path relatif dari database --}}
        <img src="{{ asset('storage/' . $movie->cover_image) }}" class="img-fluid rounded-start" alt="{{ $movie->title }}">
    @else
        {{-- Jika tidak ada gambar, gunakan placeholder --}}
        <img src="https://via.placeholder.com/300x400?text=No+Image" class="img-fluid rounded-start" alt="No Image">
    @endif
</div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">{{ $movie->title }}</h5>
        <p class="card-text">{{ Str::words($movie->synopsis, 20 ,'...') }}</p>
        <a href="{{ route('movies.detail', ['id' => $movie->id]) }}" class="btn text-white bg-success">See More</a>
      </div>
    </div>
  </div>
</div>
        </div>
        @endforeach
        {{ $movies->links() }}
    </div>
</body>
</html>

@endsection