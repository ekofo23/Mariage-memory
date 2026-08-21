@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-serif fw-bold text-dark mb-0">Modifier la Photo</h4>
                        <p class="text-muted small mb-0">Mettez à jour les informations ou remplacez le fichier HD.</p>
                    </div>
                    <a href="{{ route('admin.photos.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                        <i class="fa-solid fa-arrow-left me-1"></i> Retour
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Aperçu Actuel -->
                        <div class="mb-4 text-center">
                            <label class="form-label font-serif fw-bold d-block">Image Actuelle</label>
                            <img src="{{ asset($photo->thumbnail_path) }}" class="rounded-3 shadow-sm" style="max-height: 180px; object-fit: cover;">
                        </div>

                        <!-- Titre -->
                        <div class="mb-3">
                            <label for="title" class="form-label font-serif fw-bold">Titre de la photo</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $photo->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Catégorie & Code -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="category_id" class="form-label font-serif fw-bold">Catégorie</label>
                                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $photo->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="code" class="form-label font-serif fw-bold">Code unique</label>
                                <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $photo->code) }}">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Changer l'image (Optionnel) -->
                        <div class="mb-4">
                            <label for="image" class="form-label font-serif fw-bold">Remplacer la photo HD (Optionnel)</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Laissez vide si vous ne souhaitez pas modifier le fichier image actuel.</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-wedding py-2">
                                <i class="fa-solid fa-floppy-disk me-2"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection