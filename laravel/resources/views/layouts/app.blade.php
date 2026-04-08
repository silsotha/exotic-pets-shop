<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExoticPets — @yield('title', 'Панель управления')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }

        /* Sidebar */
        #sidebar {
            width: 260px;
            min-height: 100vh;
            background: #1a1f2e;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: width 0.2s;
            display: flex;
            flex-direction: column;
        }
        #sidebar .sidebar-logo {
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            color: #fff;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        #sidebar .sidebar-logo span { color: #4dabf7; }
        #sidebar .nav-label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.35);
            padding: 1rem 1.5rem 0.3rem;
        }
        #sidebar .nav-link {
            color: rgba(255,255,255,0.7);
            padding: 0.55rem 1.5rem;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.92rem;
            transition: all 0.15s;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left: 3px solid #4dabf7;
        }
        #sidebar .nav-link i { font-size: 1rem; width: 18px; }
        #sidebar .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.08);
            color: rgba(255,255,255,0.5);
            font-size: 0.82rem;
        }

        /* Main content */
        #main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar */
        #topbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 0.65rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        @media (max-width: 768px) {
            #sidebar { width: 0; overflow: hidden; }
            #sidebar.show { width: 260px; }
            #main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

{{-- Sidebar --}}
<nav id="sidebar">
    <div class="sidebar-logo">
        🦎 <span>Exotic</span>Pets
    </div>

    {{-- Общие разделы --}}
    <div class="nav-label">Каталог</div>
    <a href="{{ route('animals.index') }}"
       class="nav-link {{ request()->routeIs('animals.*') ? 'active' : '' }}">
        <i class="bi bi-grid"></i> Животные
    </a>

    {{-- Ветеринария --}}
    @if(auth()->user()->isAdmin() || auth()->user()->isVet())
    <div class="nav-label">Ветеринария</div>
    <a href="{{ route('vet.index') }}"
       class="nav-link {{ request()->routeIs('vet.*') ? 'active' : '' }}">
        <i class="bi bi-heart-pulse"></i> Ветзаписи
    </a>
    @endif

    {{-- Продажи --}}
    @if(auth()->user()->isAdmin() || auth()->user()->isSeller())
    <div class="nav-label">Торговля</div>
    <a href="{{ route('sales.index') }}"
       class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
        <i class="bi bi-bag-check"></i> Продажи
    </a>
    <a href="{{ route('clients.index') }}"
       class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Клиенты
    </a>
    @endif

    {{-- Только администратор --}}
    @if(auth()->user()->isAdmin())
    <div class="nav-label">Аналитика</div>
    <a href="{{ route('dashboard') }}"
       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-line"></i> Dashboard
    </a>

    <div class="nav-label">Управление</div>
    <a href="{{ route('species.index') }}"
       class="nav-link {{ request()->routeIs('species.*') ? 'active' : '' }}">
        <i class="bi bi-bookmarks"></i> Виды животных
    </a>
    <a href="{{ route('suppliers.index') }}"
       class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
        <i class="bi bi-truck"></i> Поставщики
    </a>
    <a href="{{ route('employees.index') }}"
       class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
        <i class="bi bi-person-badge"></i> Сотрудники
    </a>
    @endif

    <div class="sidebar-footer">
        {{ auth()->user()->name }}<br>
        <span class="badge bg-secondary">{{ auth()->user()->role }}</span>
    </div>
</nav>

{{-- Main --}}
<div id="main-content">

    {{-- Topbar --}}
    <div id="topbar">
        <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <div class="text-muted small">
            @yield('breadcrumb', 'ExoticPets Admin')
        </div>
        <div class="d-flex align-items-center gap-3">
            <span class="text-muted small d-none d-md-inline">
                {{ now()->format('d.m.Y') }}
            </span>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Выйти
                </button>
            </form>
        </div>
    </div>

    {{-- Контент страницы --}}
    <div class="flex-grow-1">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Мобильный togglew
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>