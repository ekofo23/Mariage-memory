@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-serif fw-bold text-dark mb-0">Téléversement de Photos en Masse</h4>
                        <p class="text-muted small mb-0">Sélectionnez plusieurs photos simultanément pour les ajouter à l'album.</p>
                    </div>
                    <a href="{{ route('admin.photos.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                        <i class="fa-solid fa-arrow-left me-1"></i> Retour
                    </a>
                </div>

                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.photos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Sélection de la Catégorie -->
                        <div class="mb-4">
                            <label for="category_id" class="form-label font-serif fw-bold">Catégorie des photos</label>
                            <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Choisir une catégorie --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Zone de sélection tactile/mobile friendly -->
                        <div class="mb-4">
                            <label class="form-label font-serif fw-bold">Sélectionner les Photos HD (Multiple)</label>
                            
                            <div class="border border-2 border-dashed rounded-4 p-4 text-center bg-light position-relative" id="dropZone" style="cursor: pointer; border-color: rgba(179, 139, 66, 0.4) !important;">
                                <i class="fa-solid fa-cloud-arrow-up fs-1 text-danger mb-2"></i>
                                <p class="fw-bold mb-1">Appuyez ou glissez vos photos ici</p>
                                <small class="text-muted d-block mb-3">Fonctionne sur smartphone (sélection multiple) & PC. Formats : JPG, PNG, WEBP.</small>
                                
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-4">
                                    <i class="fa-solid fa-images me-1"></i> Parcourir la galerie
                                </button>

                                <!-- Input transparent recouvrant toute la surface -->
                                <input type="file" name="images[]" id="images" 
                                       class="position-absolute top-0 start-0 w-100 h-100 opacity-0" 
                                       style="cursor: pointer;"
                                       accept="image/*" 
                                       multiple 
                                       required 
                                       onchange="previewImages()">
                            </div>

                            @error('images')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Container de prévisualisation des images -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2 d-none" id="previewHeader">
                                <p class="font-serif fw-bold mb-0">Aperçu des fichiers sélectionnés :</p>
                                <span class="badge bg-danger rounded-pill" id="fileCountBadge">0 photo(s)</span>
                            </div>
                            <div class="row g-2" id="imagePreviewContainer"></div>
                        </div>

                        <!-- Bouton d'envoi -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-wedding py-3" id="submitBtn">
                                <i class="fa-solid fa-cloud-arrow-up me-2"></i> Téléverser toutes les photos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImages() {
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewHeader = document.getElementById('previewHeader');
        const fileCountBadge = document.getElementById('fileCountBadge');
        const files = document.getElementById('images').files;

        previewContainer.innerHTML = '';

        if (files.length > 0) {
            previewHeader.classList.remove('d-none');
            fileCountBadge.innerText = files.length + ' photo(s)';
        } else {
            previewHeader.classList.add('d-none');
        }

        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-4 col-sm-3 col-md-2 position-relative';

                    col.innerHTML = `
                        <div class="rounded-3 overflow-hidden shadow-sm border bg-white" style="height: 80px;">
                            <img src="${e.target.result}" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    `;

                    previewContainer.appendChild(col);
                }

                reader.readAsDataURL(file);
            }
        });
    }
</script>
@endsection