<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXO PETS — @yield('title', 'Магазин экзотических животных')</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🌿</text></svg>">
    <link
        rel="stylesheet"
        href="{{ asset('css/base.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('css/public.css') }}"
    >
    @stack('styles')
</head>

<body>

    <nav class="pub-navbar">
        <a href="{{ route('home') }}" class="pub-logo" aria-label="EXO PETS — на главную">
            <img src="{{ asset('images/logo.png') }}" alt="EXO PETS" class="pub-logo-img">
        </a>
        <div class="pub-nav-links">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
            <a href="{{ route('catalog') }}" class="{{ request()->routeIs('catalog*') ? 'active' : '' }}">Каталог</a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">О нас</a>
            <a href="{{ route('how-to-choose') }}">Как выбрать животное</a>
        </div>
        <div class="pub-nav-right">
            @auth
                @php
                    $panelRoute = match(auth()->user()->role) {
                        'администратор' => route('dashboard'),
                        'ветврач'       => route('vet.index'),
                        'продавец'      => route('animals.index'),
                        'клиент'        => route('cabinet.index'),
                        default         => route('home'),
                    };

                    $panelLabel = auth()->user()->role === 'клиент'
                        ? 'Личный кабинет'
                        : 'Панель управления';
                @endphp

                @if(!(auth()->user()->role === 'клиент' && (request()->routeIs('cabinet.*') || request()->routeIs('profile.*'))))
                    <a href="{{ $panelRoute }}" class="btn-login">{{ $panelLabel }}</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-login">Войти в систему</a>
            @endauth
        </div>
    </nav>

    @yield('content')

    <div
        style="background: var(--forest); color: rgba(245,239,230,0.5); text-align:center; padding: 24px; font-size: 13px; margin-top: 64px;">
        🌿 <strong style="color: var(--cream)">EXO PETS</strong> — магазин экзотических животных
        &nbsp;·&nbsp; 📍 Москва, ул. Примерная, 1
        &nbsp;·&nbsp; 📞 +7 (920) 000-00-00
    </div>

    <script>
    // при восстановлении страницы из bfcache (кнопка "назад") — перезагрузить (для работы авторизации)
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) window.location.reload();
    });
    </script>

    @stack('scripts')
</body>

</html>