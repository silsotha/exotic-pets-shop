@extends(auth()->user()->role === 'клиент' ? 'layouts.public' : 'layouts.app')

@section('title', 'Настройки профиля')

@if(auth()->user()->role === 'клиент')
    @push('styles')
        <link
            rel="stylesheet"
            href="{{ asset('css/cabinet.css') }}"
        >
    @endpush
@endif

@section('content')
    @if(auth()->user()->role === 'клиент')
        <section class="profile-page">
            <div class="profile-shell">
                <div class="profile-head">
                    <div>
                        <div class="section-label">Профиль</div>
                        <h1>Настройки аккаунта</h1>
                        <p>Здесь можно изменить данные входа и пароль.</p>
                    </div>

                    <a href="{{ route('cabinet.index') }}" class="profile-back">
                        ← В личный кабинет
                    </a>
                </div>

                @if(session('status') === 'profile-updated')
                    <div class="profile-alert profile-alert-success">
                        Данные профиля обновлены.
                    </div>
                @endif

                @if(session('status') === 'password-updated')
                    <div class="profile-alert profile-alert-success">
                        Пароль успешно изменён.
                    </div>
                @endif

                <div class="profile-grid">
                    <div class="profile-card">
                        <h2>Данные аккаунта</h2>

                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="profile-field">
                                <label>Имя</label>
                                <input type="text"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       required>

                                @error('name')
                                    <div class="profile-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="profile-field">
                                <label>Email / логин</label>
                                <input type="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required>

                                @error('email')
                                    <div class="profile-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="profile-btn">
                                Сохранить данные
                            </button>
                        </form>
                    </div>

                    <div class="profile-card">
                        <h2>Смена пароля</h2>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="profile-field">
                                <label>Текущий пароль</label>
                                <input type="password"
                                       name="current_password"
                                       autocomplete="current-password"
                                       required>

                                @error('current_password', 'updatePassword')
                                    <div class="profile-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="profile-field">
                                <label>Новый пароль</label>
                                <input type="password"
                                       name="password"
                                       autocomplete="new-password"
                                       required>

                                @error('password', 'updatePassword')
                                    <div class="profile-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="profile-field">
                                <label>Повтор нового пароля</label>
                                <input type="password"
                                       name="password_confirmation"
                                       autocomplete="new-password"
                                       required>
                            </div>

                            <button type="submit" class="profile-btn profile-btn-green">
                                Изменить пароль
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="container py-4" style="max-width: 700px">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">Профиль</h2>
                    <div class="text-muted">Настройки аккаунта и смена пароля</div>
                </div>

                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                    ← Назад
                </a>
            </div>

            @if(session('status') === 'profile-updated')
                <div class="alert alert-success">Данные профиля обновлены.</div>
            @endif

            @if(session('status') === 'password-updated')
                <div class="alert alert-success">Пароль успешно изменён.</div>
            @endif

            <div class="card mb-4">
                <div class="card-header fw-bold">Данные аккаунта</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email / логин</label>
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}"
                                   required>

                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Сохранить данные
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold">Смена пароля</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Текущий пароль</label>
                            <input type="password"
                                   name="current_password"
                                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                   autocomplete="current-password"
                                   required>

                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Новый пароль</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                   autocomplete="new-password"
                                   required>

                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Повтор нового пароля</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   autocomplete="new-password"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-success">
                            Изменить пароль
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection