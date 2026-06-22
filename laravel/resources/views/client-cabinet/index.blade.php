@extends('layouts.public')

@section('title', 'Личный кабинет')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/cabinet.css') }}"
    >
@endpush

@section('content')
    <section class="cabinet-hero">
        <div>
            <div class="section-label">Личный кабинет</div>
            <h1 class="cabinet-title">Здравствуйте, {{ $client->full_name }}</h1>
            <p class="cabinet-subtitle">
                Здесь собрана история ваших покупок и рекомендации по уходу за приобретёнными животными.
            </p>
        </div>

        <div class="cabinet-actions">
            <a href="{{ route('profile.edit') }}" class="cabinet-action-link">
                Изменить пароль
            </a>

            <form method="POST" action="{{ route('logout') }}" class="cabinet-action-form">
                @csrf
                <button class="cabinet-action-link cabinet-action-danger" type="submit">
                    Выйти
                </button>
            </form>
        </div>
    </section>

    <section class="cabinet-wrap">
        <div class="cabinet-profile-card">
            <div class="cabinet-card-label">Профиль клиента</div>

            <div class="cabinet-profile-name">
                {{ $client->full_name }}
            </div>

            <div class="cabinet-info-list">
                <div>
                    <span>Email</span>
                    <strong>{{ $client->email }}</strong>
                </div>

                <div>
                    <span>Телефон</span>
                    <strong>{{ $client->phone ?? 'не указан' }}</strong>
                </div>

                <div>
                    <span>Дата регистрации</span>
                    <strong>{{ $client->registration_date ?? 'не указана' }}</strong>
                </div>

                <div>
                    <span>Количество покупок</span>
                    <strong>{{ $sales->count() }}</strong>
                </div>

                <div>
                    <span>Общая сумма покупок</span>
                    <strong>{{ number_format($totalSpent, 0, ',', ' ') }} ₽</strong>
                </div>
            </div>
        </div>

        <div class="cabinet-main">
            <div class="cabinet-section-head">
                <div>
                    <div class="section-label">Покупки</div>
                    <h2>История покупок</h2>
                </div>

                <span class="cabinet-count">
                    {{ $sales->count() }} покупок
                </span>
            </div>

            @forelse($sales as $sale)
                @php
                    $animal = $sale->animal;
                    $species = $animal->species ?? null;

                    $careLevelLabels = [
                        'beginner' => 'Подходит новичкам',
                        'intermediate' => 'Средняя сложность',
                        'advanced' => 'Для опытных владельцев',
                    ];
                @endphp

                <article class="cabinet-purchase-card">
                    <div class="purchase-top">
                        <div>
                            <h3>{{ $animal->name ?? 'Животное' }}</h3>
                            <p>{{ $species->name ?? 'Вид не указан' }}</p>
                        </div>

                        <div class="purchase-price">
                            {{ number_format($sale->total_price, 0, ',', ' ') }} ₽
                        </div>
                    </div>

                    <div class="purchase-meta">
                        <span>Дата покупки: {{ $sale->sale_date }}</span>
                        <span>Договор: {{ $sale->contract_number ?? 'не указан' }}</span>
                        <span>Оплата: {{ $sale->payment_method ?? 'не указана' }}</span>
                    </div>

                    <div class="care-box">
                        <h4>Рекомендации по уходу</h4>

                        @if($species)
                            <div class="care-grid">
                                @if($species->care_level)
                                    <div class="care-item">
                                        <span>Сложность</span>
                                        <strong>{{ $careLevelLabels[$species->care_level] ?? $species->care_level }}</strong>
                                    </div>
                                @endif

                                @if($species->temp_min && $species->temp_max)
                                    <div class="care-item">
                                        <span>Температура</span>
                                        <strong>{{ $species->temp_min }}–{{ $species->temp_max }} °C</strong>
                                    </div>
                                @endif

                                @if($species->humidity_min && $species->humidity_max)
                                    <div class="care-item">
                                        <span>Влажность</span>
                                        <strong>{{ $species->humidity_min }}–{{ $species->humidity_max }}%</strong>
                                    </div>
                                @endif

                                @if($species->quarantine_days)
                                    <div class="care-item">
                                        <span>Карантин</span>
                                        <strong>{{ $species->quarantine_days }} дней</strong>
                                    </div>
                                @endif
                            </div>

                            @if($species->habitat)
                                <p class="care-text">
                                    <strong>Среда обитания:</strong> {{ $species->habitat }}
                                </p>
                            @endif

                            @if($species->description)
                                <p class="care-text">
                                    {{ $species->description }}
                                </p>
                            @endif
                        @else
                            <p class="care-text">Рекомендации пока не указаны.</p>
                        @endif
                    </div>
                </article>
            @empty
                <div class="cabinet-empty">
                    <h3>Покупок пока нет</h3>
                    <p>
                        После оформления покупки в магазине здесь появится история приобретённых животных
                        и персональные рекомендации по уходу.
                    </p>
                    <a href="{{ route('catalog') }}" class="btn-primary">Посмотреть каталог</a>
                </div>
            @endforelse
        </div>
    </section>
@endsection