@extends('layouts.public')
@section('title', 'Главная')

@section('content')

    <div class="pub-hero">
        <div class="hero-content">
            <div class="hero-badge">🦎 Экзотические животные</div>
            <h1 class="hero-title">Мир <em>редких</em><br>созданий рядом</h1>
            <p class="hero-sub">
                Рептилии, амфибии, птицы и насекомые от проверенных поставщиков.
                Полная ветеринарная документация для каждого питомца.
            </p>
            <div class="hero-btns">
                <a href="{{ route('catalog') }}" class="btn-primary">Смотреть каталог</a>
                <a href="#categories" class="btn-outline">Узнать подробнее</a>
            </div>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <strong>{{ $availableCount }}</strong>
                <span>Доступно сейчас</span>
            </div>
            <div class="hero-stat">
                <strong>{{ $speciesCount }}</strong>
                <span>Видов животных</span>
            </div>
            <div class="hero-stat">
                <strong>{{ $suppliersCount }}</strong>
                <span>Поставщиков</span>
            </div>
        </div>
    </div>

    {{-- категории --}}
    <div class="pub-section" id="categories">
        <div class="section-label">Категории</div>
        <div class="section-title">Выберите вашего питомца</div>
        <div class="categories-grid">
            @php
                $icons = [
                    'рептилии' => '🦎',
                    'амфибии' => '🐸',
                    'птицы' => '🦜',
                    'насекомые' => '🦋',
                    'млекопитающие' => '🐭',
                    'рыбы' => '🐟',
                    'паукообразные' => '🕷',
                ];
            @endphp
            @foreach($categoryCounts as $class => $count)
                <a href="{{ route('catalog', ['class' => $class]) }}" style="text-decoration:none">
                    <div class="cat-card">
                        <span class="cat-icon">{{ $icons[$class] ?? '🐾' }}</span>
                        <div class="cat-name">{{ ucfirst($class) }}</div>
                        <div class="cat-count">{{ $count }} особей</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- новые поступления --}}
    <div class="pub-section" style="background: var(--mist); padding-top: 52px; padding-bottom: 52px">
        <div class="section-label">Новые поступления</div>
        <div class="section-title">Только что в магазине</div>

        @if($newArrivals->count() > 0)
            <div class="animals-grid">
                @foreach($newArrivals as $animal)
                    @include('public._card', ['animal' => $animal])
                @endforeach
            </div>
            <div style="text-align:center; margin-top: 36px">
                <a href="{{ route('catalog') }}" class="btn-primary">Смотреть всех животных</a>
            </div>
        @else
            <p style="color: var(--smoke); text-align:center; padding: 32px 0">
                Скоро появятся новые животные!
            </p>
        @endif
    </div>

@endsection