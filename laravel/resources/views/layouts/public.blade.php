<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExoticPets — @yield('title', 'Магазин экзотических животных')</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌿</text></svg>">
</head>

<body>

    <nav class="pub-navbar">
        <div class="pub-logo">
            <span class="leaf">🌿</span> ExoticPets
        </div>
        <div class="pub-nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
            <a href="{{ route('catalog') }}" class="{{ request()->routeIs('catalog*') ? 'active' : '' }}">Каталог</a>
        </div>
        <div class="pub-nav-right">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-login">Панель управления</a>
            @else
                <a href="{{ route('login') }}" class="btn-login">Войти в систему</a>
            @endauth
        </div>
    </nav>

    @yield('content')

    <div
        style="background: var(--forest); color: rgba(245,239,230,0.5); text-align:center; padding: 24px; font-size: 13px; margin-top: 64px;">
        🌿 <strong style="color: var(--cream)">ExoticPets</strong> — магазин экзотических животных
        &nbsp;·&nbsp; 📍 Москва, ул. Примерная, 1
        &nbsp;·&nbsp; 📞 +7 (920) 000-00-00
    </div>

    @stack('scripts')
</body>

</html>