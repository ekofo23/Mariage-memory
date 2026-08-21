@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center my-4">
        <div class="col-md-5">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background-color: #ffffff;">
                <div class="card-header border-0 text-center pt-4 pb-2" style="background-color: var(--bg-rose-dark);">
                    <p class="font-script fs-2 text-dark mb-0">Espace Privé</p>
                    <h5 class="font-serif fw-bold text-dark mb-0">Connexion Administrateur</h5>
                </div>

                <div class="card-body p-4">
                    @if(session('status'))
                        <div class="alert alert-success rounded-3 mb-3">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Adresse Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label font-serif fw-bold">Adresse Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fa-solid fa-envelope text-muted"></i>
                                </span>
                                <input type="email" name="email" id="email" class="form-control border-start-0 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="admin@mariage.com" required autofocus>
                            </div>
                            @error('email')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-3">
                            <label for="password" class="form-label font-serif fw-bold">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fa-solid fa-lock text-muted"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control border-start-0 @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            </div>
                            @error('password')
                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Se souvenir de moi -->
                        <div class="mb-4 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label small text-muted" for="remember">Se souvenir de moi</label>
                        </div>

                        <!-- Bouton Se Connecter -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-wedding py-2">
                                <i class="fa-solid fa-right-to-bracket me-2"></i> Se connecter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection