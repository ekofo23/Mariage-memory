@extends('layouts.app')

@section('content')
<style>
    .album-header {
        padding: 60px 0 30px 0;
        background: linear-gradient(180deg, var(--bg-rose-dark) 0%, var(--bg-rose-medium) 100%);
        text-align: center;
        border-bottom: 1px solid rgba(179, 139, 66, 0.2);
    }
    .album-title {
        font-family: var(--font-script);
        font-size: 4rem;
        color: var(--text-dark);
        margin-bottom: 10px;
    }
    .album-subtext {
        font-family: var(--font-serif);
        font-size: 1.1rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--accent-red);
        font-weight: 600;
    }

    /* Champ de recherche */
    .search-input-group {
        max-width: 500px;
        margin: 0 auto;
    }
    .search-input {
        border-radius: 30px;
        padding: 10px 20px;
        border: 1px solid rgba(179, 139, 66, 0.4);
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    }
    .search-input:focus {
        border-color: var(--accent-red);
        box-shadow: 0 0 0 0.25rem rgba(139, 18, 26, 0.15);
    }

    /* Filtres */
    .filter-btn {
        background-color: #ffffff;
        color: var(--text-dark);
        border: 1px solid rgba(179, 139, 66, 0.3);
        border-radius: 30px;
        padding: 8px 22px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin: 4px;
        transition: all 0.3s ease;
    }
    .filter-btn:hover, .filter-btn.active {
        background-color: var(--accent-red);
        color: #ffffff;
        border-color: var(--accent-red);
        box-shadow: 0 4px 12px rgba(139, 18, 26, 0.2);
    }

    /* Cartes Photo Galerie */
    .gallery-card {
        border-radius: 16px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid rgba(179, 139, 66, 0.2);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
    }
    .gallery-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }
    .gallery-img-container {
        height: 280px;
        overflow: hidden;
        position: relative;
        cursor: pointer;
    }
    .gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .gallery-card:hover .gallery-img {
        transform: scale(1.06);
    }
    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: rgba(31, 26, 23, 0.4);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.3s ease;
    }
    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }
    .gallery-caption {
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #ffffff;
    }
</style>

<!-- En-tête -->
<section class="album-header">
    <div class="container">
        <p class="album-subtext">Galerie Souvenir</p>
        <h1 class="album-title">L'Album de Mariage</h1>
        <p class="text-muted small">Retrouvez toutes les photos de notre journée spéciale et téléchargez vos préférées en haute définition.</p>
        
        <!-- Bouton Télécharger Tout en ZIP -->
        <div class="mt-3">
            <a href="{{ route('album.downloadZip') }}" class="btn btn-wedding">
                <i class="fa-solid fa-file-zipper me-2"></i> Télécharger tout l'album (ZIP)
            </a>
        </div>
    </div>
</section>

<!-- Galerie -->
<section class="py-5" style="background-color: var(--bg-rose-medium);">
    <div class="container">
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Barre de recherche -->
        <div class="mb-4 search-input-group">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 rounded-pill-start ps-3">
                    <i class="fa-solid fa-magnifying-glass text-muted"></i>
                </span>
                <input type="text" id="searchInput" onkeyup="applyFilters()" class="form-control border-start-0 search-input ps-0" placeholder="Rechercher par titre ou code (ex: PHOTO-001)...">
            </div>
        </div>

        <!-- Boutons Filtres Dynamiques -->
        <div class="text-center mb-5">
            <button class="filter-btn active" data-category="all" onclick="selectCategory('all', event)">Toutes</button>
            @foreach($categories as $category)
                <button class="filter-btn" data-category="{{ $category->slug ?? $category->id }}" onclick="selectCategory('{{ $category->slug ?? $category->id }}', event)">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Message aucun résultat -->
        <div id="noResults" class="text-center py-5 d-none">
            <i class="fa-solid fa-image text-muted fs-1 mb-3 d-block"></i>
            <p class="text-muted font-serif fs-5">Aucune photo ne correspond à votre recherche.</p>
        </div>

        <!-- Grille de Photos -->
        <div class="row g-4" id="galleryGrid">
            @foreach($photos as $photo)
            <div class="col-md-6 col-lg-4 gallery-item" 
                 data-category="{{ $photo->category->slug ?? $photo->category_id }}"
                 data-title="{{ strtolower($photo->title) }}"
                 data-code="{{ strtolower($photo->code ?? '') }}">
                <div class="gallery-card">
                    <div class="gallery-img-container" onclick="openLightbox('{{ asset($photo->original_path) }}', '{{ $photo->title }}')">
                        <img src="{{ asset($photo->thumbnail_path) }}" alt="{{ $photo->title }}" class="gallery-img">
                        <div class="gallery-overlay">
                            <span class="btn btn-sm btn-light rounded-circle p-3">
                                <i class="fa-solid fa-magnifying-glass-plus text-dark fs-5"></i>
                            </span>
                        </div>
                    </div>
                    <div class="gallery-caption">
                        <div>
                            <span class="font-serif fw-bold text-dark fs-5 d-block">{{ $photo->title }}</span>
                            @if($photo->code)
                                <small class="text-muted">Code: {{ $photo->code }}</small>
                            @endif
                        </div>
                        <a href="{{ route('album.download', $photo->id) }}" class="btn btn-sm btn-outline-danger rounded-circle p-2" title="Télécharger HD">
                            <i class="fa-solid fa-download"></i>
                        </a>
                    </div>

                    {{-- BLOC ACTIONS ADMIN (VISIBLE UNIQUEMENT SI CONNECTÉ) --}}
                    @auth
                        <div class="px-3 pb-3 pt-2 bg-light border-top d-flex justify-content-between align-items-center">
                            <a href="{{ route('admin.photos.edit', $photo->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="fa-solid fa-pen me-1"></i> Modifier
                            </a>

                            <form action="{{ route('admin.photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette photo ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="fa-solid fa-trash me-1"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    @endauth

                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Lightbox Modal -->
<div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center p-0 position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <img id="lightboxImage" src="" class="img-fluid rounded-3 shadow-lg" style="max-height: 85vh; object-fit: contain;">
                <p id="lightboxCaption" class="text-white font-script fs-2 mt-3 mb-0"></p>
            </div>
        </div>
    </div>
</div>

<script>
    let currentCategory = 'all';

    function selectCategory(category, event) {
        currentCategory = category;
        let buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        if (event && event.target) {
            event.target.classList.add('active');
        }
        applyFilters();
    }

    function applyFilters() {
        let searchValue = document.getElementById('searchInput').value.toLowerCase().trim();
        let items = document.querySelectorAll('.gallery-item');
        let visibleCount = 0;

        items.forEach(item => {
            let itemCategory = item.getAttribute('data-category');
            let itemTitle = item.getAttribute('data-title') || '';
            let itemCode = item.getAttribute('data-code') || '';

            let matchesCategory = (currentCategory === 'all' || itemCategory === currentCategory);
            let matchesSearch = (itemTitle.includes(searchValue) || itemCode.includes(searchValue));

            if (matchesCategory && matchesSearch) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Afficher/masquer le message "Aucun résultat"
        let noResults = document.getElementById('noResults');
        if (visibleCount === 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
    }

    function openLightbox(src, title) {
        document.getElementById('lightboxImage').src = src;
        document.getElementById('lightboxCaption').innerText = title;
        let modal = new bootstrap.Modal(document.getElementById('lightboxModal'));
        modal.show();
    }
</script>
@endsection