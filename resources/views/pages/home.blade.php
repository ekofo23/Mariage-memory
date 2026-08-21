@extends('layouts.app')

@section('content')
<style>
    .hero-banner {
        padding: 75px 0 55px 0;
        background: linear-gradient(180deg, var(--bg-rose-dark) 0%, var(--bg-rose-medium) 100%);
        text-align: center;
        border-bottom: 1px solid rgba(179, 139, 66, 0.2);
    }
    .hero-subtext {
        font-family: var(--font-serif);
        font-size: 1.3rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent-red);
        font-weight: 600;
        margin-bottom: 10px;
    }
    .hero-names {
        font-family: var(--font-script);
        font-size: 4.5rem;
        color: var(--text-dark);
        line-height: 1.05;
        margin-bottom: 25px;
        text-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .hero-portrait-frame {
        position: relative;
        width: 230px;
        height: 290px;
        margin: 0 auto 25px auto;
        border-radius: 120px;
        padding: 8px;
        background: #ffffff;
        border: 2px solid var(--accent-gold);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }
    .hero-portrait-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 110px;
    }

    .hero-date {
        font-size: 0.95rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--text-dark);
        font-weight: 600;
    }

    .photo-card-section {
        padding: 50px 0 80px 0;
        background-color: var(--bg-rose-medium);
    }
    .photo-card-wrapper {
        background-color: #ffffff;
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(179, 139, 66, 0.25);
    }
    .carousel-card-inner {
        border-radius: 16px;
        overflow: hidden;
    }
    .carousel-card-item {
        height: 580px;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-color: #0d1117;
        position: relative;
    }
    .carousel-card-caption {
        position: absolute;
        bottom: 0;
        inset-x: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0) 100%);
        padding: 30px 20px;
        color: #ffffff;
        text-align: center;
    }

    .info-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 35px 25px;
        border: 1px solid rgba(0,0,0,0.06);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.04);
        transition: transform 0.3s ease;
    }
    .info-card:hover {
        transform: translateY(-5px);
    }
    .info-icon {
        color: var(--accent-red);
        font-size: 2rem;
        margin-bottom: 15px;
    }
</style>

<!-- SECTION 1 : Hero Principal -->
<section class="hero-banner">
    <div class="container">
        <p class="hero-subtext">Nous célébrons notre amour</p>
        <h1 class="hero-names">Phirceline Lueteta & Christ Darel Kissa</h1>
        
        <div class="hero-portrait-frame">
            <img src="{{ asset('images/hero/slide3.jpg') }}" alt="Phirceline Lueteta & Christ Darel Kissa" class="hero-portrait-img">
        </div>

        <p class="hero-date">Merci d'avoir été présents à nos côtés</p>
    </div>
</section>

<!-- SECTION 2 : Carrousel Carte (3 secondes) -->
<section class="photo-card-section">
    <div class="container" style="max-width: 960px;">
        <div class="photo-card-wrapper">
            
            <div id="weddingPhotoCarousel" class="carousel slide carousel-fade carousel-card-inner" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#weddingPhotoCarousel" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#weddingPhotoCarousel" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#weddingPhotoCarousel" data-bs-slide-to="2"></button>
                    <button type="button" data-bs-target="#weddingPhotoCarousel" data-bs-slide-to="3"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="carousel-card-item" style="background-image: url('{{ asset('images/hero/slide1.jpg') }}');">
                            <div class="carousel-card-caption">
                                <h3 class="font-script fs-1 mb-1">Moments d'Émotion</h3>
                                <p class="small text-light mb-0">Revivez les plus beaux clichés du mariage</p>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="carousel-card-item" style="background-image: url('{{ asset('images/hero/slide2.jpg') }}');">
                            <div class="carousel-card-caption">
                                <h3 class="font-script fs-1 mb-1">Cérémonie & Soirée</h3>
                                <p class="small text-light mb-0">Chaque instant capturé pour l'éternité</p>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="carousel-card-item" style="background-image: url('{{ asset('images/hero/slide3.jpg') }}');">
                            <div class="carousel-card-caption">
                                <h3 class="font-script fs-1 mb-1">Sourires & Partage</h3>
                                <p class="small text-light mb-0">Des souvenirs précieux conservés en haute définition</p>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="carousel-card-item" style="background-image: url('{{ asset('images/hero/slide4.jpg') }}');">
                            <div class="carousel-card-caption">
                                <h3 class="font-script fs-1 mb-1">Album Souvenir</h3>
                                <p class="small text-light mb-0">Un espace dédié pour tous nos invités</p>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#weddingPhotoCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#weddingPhotoCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('album') }}" class="btn btn-wedding">
                    <i class="fa-solid fa-images me-2"></i> Découvrir tout l'album photo
                </a>
            </div>

        </div>
    </div>
</section>

<!-- SECTION 3 : Cartes d'information -->
<section class="pb-5" style="background-color: var(--bg-rose-medium);">
    <div class="container py-3">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="info-card h-100">
                    <div class="info-icon">
                        <i class="fa-regular fa-heart"></i>
                    </div>
                    <h4 class="font-serif fw-bold text-dark mb-2">Revivez</h4>
                    <p class="text-muted small mb-0">Parcourez les moments magiques de cette journée d'exception.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card h-100">
                    <div class="info-icon">
                        <i class="fa-solid fa-cloud-arrow-down"></i>
                    </div>
                    <h4 class="font-serif fw-bold text-dark mb-2">Téléchargez</h4>
                    <p class="text-muted small mb-0">Récupérez directement vos photos en haute définition originale.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-card h-100">
                    <div class="info-icon">
                        <i class="fa-regular fa-face-smile"></i>
                    </div>
                    <h4 class="font-serif fw-bold text-dark mb-2">Partagez</h4>
                    <p class="text-muted small mb-0">Transmettez ces beaux souvenirs à l'ensemble de la famille.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection