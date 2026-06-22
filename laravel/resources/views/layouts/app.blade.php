<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXO PETS — @yield('title', 'Панель управления')</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">
    <link rel="icon"
        href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📋</text></svg>">
    <link
        href="{{ asset('css/admin-panel.css') }}"
        rel="stylesheet">
    @stack('styles')
</head>

<body>
    @php
    $currentUser = auth()->user();

    $roleLabel = [
    'администратор' => 'Администратор',
    'продавец' => 'Продавец-консультант',
    'ветврач' => 'Ветеринар',
    ];

    $userInitial = mb_strtoupper(mb_substr($currentUser->name, 0, 1));
    @endphp

    <nav id="sidebar" aria-label="Навигация панели">
        <a
            href="{{ route('home') }}"
            class="sidebar-logo"
            aria-label="EXO PETS">
            <img
                src="{{ asset('images/logo_negate.png') }}"
                alt="EXO PETS"
                class="sidebar-logo-img">
        </a>

        <div class="sidebar-navigation">
            @if($currentUser->isAdmin() || $currentUser->isSeller())
            <div class="nav-group">
                <div class="nav-label">Каталог</div>

                <a
                    href="{{ route('animals.index') }}"
                    class="nav-link {{ request()->routeIs('animals.*') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i>
                    <span>Животные</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-label">Торговля</div>

                <a
                    href="{{ route('sales.index') }}"
                    class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">
                    <i class="bi bi-bag-check"></i>
                    <span>Продажи</span>
                </a>

                <a
                    href="{{ route('clients.index') }}"
                    class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Клиенты</span>
                </a>
            </div>
            @endif

            @if($currentUser->isAdmin() || $currentUser->isVet())
            <div class="nav-group">
                <div class="nav-label">Ветеринария</div>

                <a
                    href="{{ route('vet.index') }}"
                    class="nav-link {{ request()->routeIs('vet.*') ? 'active' : '' }}">
                    <i class="bi bi-heart-pulse"></i>
                    <span>Ветзаписи</span>
                </a>
            </div>
            @endif

            @if($currentUser->isAdmin())
            <div class="nav-group">
                <div class="nav-label">Аналитика</div>

                <a
                    href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Обзор</span>
                </a>
            </div>

            <div class="nav-group">
                <div class="nav-label">Управление</div>

                <a
                    href="{{ route('admin.species.index') }}"
                    class="nav-link {{ request()->routeIs('admin.species.*') ? 'active' : '' }}">
                    <i class="bi bi-bookmarks"></i>
                    <span>Виды животных</span>
                </a>

                <a
                    href="{{ route('admin.suppliers.index') }}"
                    class="nav-link {{ request()->routeIs('admin.suppliers.*') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i>
                    <span>Поставщики</span>
                </a>

                <a
                    href="{{ route('admin.employees.index') }}"
                    class="nav-link {{ request()->routeIs('admin.employees.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i>
                    <span>Сотрудники</span>
                </a>
            </div>
            @endif
        </div>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ $userInitial }}
                </div>

                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">
                        {{ $currentUser->name }}
                    </div>

                    <div class="sidebar-user-role">
                        {{ $roleLabel[$currentUser->role] ?? $currentUser->role }}
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div id="sidebarBackdrop"></div>

    <div id="main-content">
        <header id="topbar">
            <div class="d-flex align-items-center gap-3">
                <button
                    type="button"
                    class="btn btn-sm btn-secondary d-lg-none"
                    id="sidebarToggle"
                    aria-label="Открыть меню"
                    aria-controls="sidebar"
                    aria-expanded="false">
                    <i class="bi bi-list"></i>
                </button>

                <div class="topbar-context">
                    <div class="topbar-title">
                        @yield('page-title', 'Панель управления')
                    </div>

                    <div class="topbar-subtitle">
                        EXO PETS
                    </div>
                </div>
            </div>

            <div class="topbar-actions">
                <div class="topbar-date d-none d-md-inline-flex">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ now()->format('d.m.Y') }}</span>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf

                    <button
                        type="submit"
                        class="btn btn-sm btn-danger"
                        title="Выйти">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="d-none d-sm-inline">Выйти</span>
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-grow-1">
            <div class="admin-content">
                @if(session('success'))
                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Закрыть"></button>
                </div>
                @endif

                @if(session('error'))
                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Закрыть"></button>
                </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            const backdrop = document.getElementById('sidebarBackdrop');

            const closeSidebar = () => {
                sidebar?.classList.remove('show');
                backdrop?.classList.remove('show');
                toggle?.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            };

            const openSidebar = () => {
                sidebar?.classList.add('show');
                backdrop?.classList.add('show');
                toggle?.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            };

            toggle?.addEventListener('click', () => {
                sidebar?.classList.contains('show') ?
                    closeSidebar() :
                    openSidebar();
            });

            backdrop?.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 992) {
                    closeSidebar();
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>