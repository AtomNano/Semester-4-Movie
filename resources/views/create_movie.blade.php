
@extends('layouts.template')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow border-0">
            <div class="card-header bg-success text-white">
                <h3 class="mb-0">Tambah Movie Baru</h3>
            </div>
            <div class="card-body p-4">
             <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" required value="{{ old('title') }}">
                    </div>
                    <div class="mb-3">
                        <label for="synopsis" class="form-label">Sinopsis</label>
                        <textarea class="form-control" id="synopsis" name="synopsis" rows="3">{{ old('synopsis') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategori</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="year" name="year" min="1901" max="{{ date('Y') }}" required value="{{ old('year') }}">
                    </div>
                    <div class="mb-3">
                        <label for="actors" class="form-label">Aktor</label>
                        <input type="text" class="form-control" id="actors" name="actors" value="{{ old('actors') }}">
                        <div class="form-text">Pisahkan dengan koma jika lebih dari satu.</div>
                    </div>
                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Cover Image</label>
                        <input class="form-control" type="file" id="cover_image" name="cover_image" accept="image/*">
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg">Simpan</button>
                    </div>
                </form>
                <div class="mt-3">
                    <a href="{{ url('/') }}" class="btn btn-secondary btn-lg">Kembali ke Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection