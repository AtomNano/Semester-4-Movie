@extends('layouts.template')

@section('title', 'Film Terbaru')

@section('content')
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Search and Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <form action="{{ route('homepage') }}" method="GET" class="row g-3 align-items-center">
                    <div class="col-md">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari film..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @auth
                        <div class="col-md-auto">
                            <a href="{{ route('movies.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg"></i> Tambah Film
                            </a>
                        </div>
                    @endauth
                </form>
            </div>
        </div>

        <h2 class="mb-4">Sedang Tayang</h2>
        
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse ($movies as $movie)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            @if (filter_var($movie->cover_image, FILTER_VALIDATE_URL))
                                <img src="{{ $movie->cover_image }}" class="card-img-top" alt="{{ $movie->title }}" loading="lazy">
                            @elseif ($movie->cover_image)
                                <img src="{{ asset('storage/' . $movie->cover_image) }}" class="card-img-top" alt="{{ $movie->title }}" loading="lazy">
                            @else
                                <img src="https://via.placeholder.com/300x450?text=No+Image" class="card-img-top" alt="No Image" loading="lazy">
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $movie->title }}</h5>
                            <p class="card-text text-muted">
                                <small>
                                    <i class="bi bi-tag"></i> {{ $movie->category ? $movie->category->category_name : 'Tidak Ada Kategori' }}<br>
                                    <i class="bi bi-calendar"></i> {{ $movie->year }}
                                </small>
                            </p>
                            <a href="{{ route('movies.detail', ['id' => $movie->id, 'slug' => $movie->slug]) }}" 
                               class="btn btn-outline-primary w-100">
                                <i class="bi bi-eye"></i> Lihat Detail
                            </a>
                        </div>
                        @auth
                            <div class="card-footer bg-transparent">
                                <div class="d-flex gap-2 justify-content-between">
                                    <a href="{{ route('movies.edit', ['id' => $movie->id]) }}" 
                                       class="btn btn-warning btn-sm flex-grow-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    @if ($movie->trashed())
                                        <form action="{{ route('movies.restore', ['id' => $movie->id]) }}" 
                                              method="POST" class="flex-grow-1">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100">
                                                <i class="bi bi-arrow-counterclockwise"></i> Pulihkan
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('movies.destroy', ['id' => $movie->id]) }}" 
                                              method="POST" class="flex-grow-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm w-100" data-confirm-delete>
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> Tidak ada film ditemukan.
                    </div>
                </div>
            @endforelse
        </div>

        @if ($movies->hasPages())
            <div class="mt-4">
                {{ $movies->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    @push('styles')
    <style>
        .card-img-top {
            height: 400px;
            object-fit: cover;
        }
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('[data-confirm-delete]').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Film ini akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>
    @endpush
@endsection