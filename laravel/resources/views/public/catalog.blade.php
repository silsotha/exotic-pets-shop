@extends('layouts.public')

@section('title', 'Каталог')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/catalog.css') }}"
    >
@endpush

@section('content')
    <div class="pub-section">
        <div class="section-label">Каталог</div>
        <div class="section-title">Все животные</div>

        <form method="GET" action="{{ route('catalog') }}" class="catalog-controls">
            <select name="class" class="catalog-select">
                <option value="">Все категории</option>

                @foreach($classes as $class)
                    <option value="{{ $class }}" {{ request('class') === $class ? 'selected' : '' }}>
                        {{ $class }}
                    </option>
                @endforeach
            </select>

            <select name="care_level" class="catalog-select">
                <option value="">Любая сложность</option>

                @foreach($careLevels as $value => $label)
                    <option value="{{ $value }}" {{ request('care_level') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <select name="sort" class="catalog-select">
                <option value="">Сначала новые</option>
                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>
                    Сначала дешевле
                </option>
                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>
                    Сначала дороже
                </option>
            </select>

            <button type="submit" class="btn-primary">
                Применить
            </button>

            @if(request()->hasAny(['class', 'care_level', 'sort']))
                <a href="{{ route('catalog') }}" class="catalog-reset">
                    Сбросить
                </a>
            @endif
        </form>

        @if($animals->count() > 0)
            <div class="animals-grid">
                @foreach($animals as $animal)
                    @include('public._card', ['animal' => $animal])
                @endforeach
            </div>
            <div style="margin-top:32px">
                {{ $animals->withQueryString()->links() }}
            </div>
        @else
            <div style="text-align:center; padding: 64px 0">
                <div style="font-size:4rem">🔍</div>
                <p style="color: var(--smoke); margin-top: 12px">Животных по вашему запросу не найдено</p>
                <a href="{{ route('catalog') }}" class="btn-primary" style="display:inline-block; margin-top:20px">
                    Сбросить фильтры
                </a>
            </div>
        @endif
    </div>
@endsection