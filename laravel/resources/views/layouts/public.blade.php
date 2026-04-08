<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExoticPets — @yield('title', 'Магазин экзотических животных')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .navbar-brand span {
            color: #4dabf7;
        }

        .animal-card {
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }

        .animal-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .animal-card img {
            height: 220px;
            object-fit: cover;
            background: #e9ecef;
        }

        .animal-card .no-photo {
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #e9ecef, #dee2e6);
            font-size: 4rem;
        }

        .hero {
            background: linear-gradient(135deg, #1a1f2e 0%, #2d3561 100%);
            color: white;
            padding: 5rem 0;
        }

        .hero h1 span {
            color: #4dabf7;
        }

        footer {
            background: #1a1f2e;
            color: rgba(255, 255, 255, 0.6);
            padding: 2rem 0;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                🦎 Exotic<span>Pets</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('catalog*') ? 'active' : '' }}"
                            href="{{ route('catalog') }}">Каталог</a>
                    </li>
                </ul>
                <div class="d-flex gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-light">
                            <i class="bi bi-speedometer2"></i> Панель
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Войти</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="mt-5">
        <div class="container text-center">
            <div class="mb-2">🦎 <strong class="text-white">ExoticPets</strong> — магазин экзотических животных</div>
            <div class="small">📍 Москва, ул. Примерная, 1 &nbsp;|&nbsp; 📞 +7 (495) 000-00-00 &nbsp;|&nbsp; ✉
                info@exoticpets.ru</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>