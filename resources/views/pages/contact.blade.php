@extends('layouts.app')

@section('content')
<style>
    .contact-header {
        padding: 60px 0 30px 0;
        background: linear-gradient(180deg, var(--bg-rose-dark) 0%, var(--bg-rose-medium) 100%);
        text-align: center;
        border-bottom: 1px solid rgba(179, 139, 66, 0.2);
    }
    .contact-title {
        font-family: var(--font-script);
        font-size: 4rem;
        color: var(--text-dark);
        margin-bottom: 10px;
    }
    .contact-subtext {
        font-family: var(--font-serif);
        font-size: 1.1rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--accent-red);
        font-weight: 600;
    }

    .contact-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(179, 139, 66, 0.25);
    }
    .form-control {
        border-radius: 10px;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        background-color: #fdfbf7;
    }
    .form-control:focus {
        border-color: var(--accent-gold);
        box-shadow: 0 0 0 0.25rem rgba(179, 139, 66, 0.2);
        background-color: #ffffff;
    }
</style>

<!-- En-tête -->
<section class="contact-header">
    <div class="container">
        <p class="contact-subtext">Besoin d'aide ?</p>
        <h1 class="contact-title">Assistance & Contact</h1>
        <p class="text-muted small">Une question sur les photos ou un problème de téléchargement ? Écrivez-nous !</p>
    </div>
</section>

<!-- Formulaire et Infos -->
<section class="py-5" style="background-color: var(--bg-rose-medium);">
    <div class="container" style="max-width: 900px;">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="contact-card">
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label font-serif fw-bold small text-uppercase">Nom Complet</label>
                        <input type="text" name="name" class="form-control" placeholder="Votre nom" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-serif fw-bold small text-uppercase">Adresse Email</label>
                        <input type="email" name="email" class="form-control" placeholder="votre.email@example.com" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label font-serif fw-bold small text-uppercase">Sujet</label>
                        <input type="text" name="subject" class="form-control" placeholder="Ex: Problème de téléchargement HD" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label font-serif fw-bold small text-uppercase">Message</label>
                        <textarea name="message" rows="5" class="form-control" placeholder="Décrivez votre demande..." required></textarea>
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-wedding">
                            <i class="fa-solid fa-paper-plane me-2"></i> Envoyer le message
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</section>
@endsection