<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mariage Phirceline Lueteta & Christ Darel Kissa</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cormorant+Garamond:ital,wght@0,500;0,600;1,400&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-rose-medium: #e8d8ce;
            --bg-rose-dark: #d9c3b3;
            --text-dark: #1f1a17;
            --text-muted: #5c524c;
            --accent-red: #8b121a;
            --accent-gold: #b38b42;
            --font-script: 'Great Vibes', cursive;
            --font-serif: 'Cormorant Garamond', serif;
            --font-sans: 'Montserrat', sans-serif;
        }
        body {
            background-color: var(--bg-rose-medium);
            color: var(--text-dark);
            font-family: var(--font-sans);
            -webkit-font-smoothing: antialiased;
        }
        .font-script { font-family: var(--font-script); }
        .font-serif { font-family: var(--font-serif); }

        .navbar-minimal {
            background-color: var(--bg-rose-dark);
            padding: 22px 0;
            border-bottom: 2px solid rgba(179, 139, 66, 0.3);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .nav-link-minimal {
            color: var(--text-dark) !important;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 10px 20px !important;
            margin: 0 4px;
            transition: all 0.3s ease;
        }
        .nav-link-minimal:hover, .nav-link-minimal.active {
            color: var(--accent-red) !important;
            background-color: rgba(255, 255, 255, 0.4);
            border-radius: 20px;
        }

        /* Style spécifique pour le bouton d'upload Admin */
        .nav-link-admin {
            color: #ffffff !important;
            background-color: var(--accent-red);
            border-radius: 20px;
        }
        .nav-link-admin:hover {
            background-color: #6b0c12 !important;
            color: #ffffff !important;
        }

        .btn-wedding {
            background-color: var(--accent-red);
            color: #ffffff;
            border: none;
            font-size: 0.85rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 600;
            padding: 14px 32px;
            border-radius: 50px;
            box-shadow: 0 6px 18px rgba(139, 18, 26, 0.25);
            transition: all 0.3s ease;
        }
        .btn-wedding:hover {
            background-color: #6b0c12;
            color: #ffffff;
            transform: translateY(-2px);
        }

        footer {
            background-color: var(--bg-rose-dark);
            color: var(--text-dark);
            border-top: 2px solid rgba(179, 139, 66, 0.3);
            padding: 45px 0 !important;
            font-size: 0.95rem;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <nav class="navbar navbar-expand-lg navbar-minimal sticky-top">
        <div class="container justify-content-between">
            <a class="navbar-brand font-script fs-1 text-dark fw-bold" href="{{ route('home') }}">
                Phirceline Lueteta & Christ Darel Kissa
            </a>
            <div class="d-flex align-items-center">
                <a class="nav-link nav-link-minimal {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Accueil</a>
                <a class="nav-link nav-link-minimal {{ request()->routeIs('album*') ? 'active' : '' }}" href="{{ route('album') }}">Album Photos</a>
                <a class="nav-link nav-link-minimal {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Assistance</a>

                {{-- SI L'ADMINISTRATEUR EST CONNECTÉ --}}
                @auth
                    <a class="nav-link nav-link-minimal nav-link-admin ms-2 {{ request()->routeIs('admin.photos.create') ? 'active' : '' }}" href="{{ route('admin.photos.create') }}">
                        <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="d-inline ms-2">
                        @csrf
                        <button type="submit" class="btn nav-link nav-link-minimal text-danger border-0 bg-transparent p-0" title="Déconnexion">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                @endauth

                {{-- SI L'ADMINISTRATEUR N'EST PAS CONNECTÉ --}}
                @guest
                    <a class="nav-link nav-link-minimal ms-2" href="{{ route('login') }}" title="Espace Administrateur">
                        <i class="fa-solid fa-lock me-1"></i> Connexion
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer>
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <p class="font-script fs-2 mb-0">Phirceline Lueteta & Christ Darel Kissa</p>
                <small class="text-muted">Souvenirs inoubliables de notre mariage</small>
            </div>
            <div class="text-end">
                <p class="mb-0 font-serif fw-bold">&copy; 2025 Tous droits réservés.</p>
                <small class="text-muted">Merci pour votre présence</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>