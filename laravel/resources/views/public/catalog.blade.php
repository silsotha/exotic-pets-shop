@extends('layouts.public')
@section('title', 'Каталог')

@section('content')
    <div class="pub-section">
        <div class="section-label">Каталог</div>
        <div class="section-title">Все животные</div>

        <form method="GET">
            <div class="catalog-controls">
                <select name="class" class="catalog-select" onchange="this.form.submit()">
                    <option value="">Все категории</option>
                    @foreach($classes as $cls)
                        <option value="{{ $cls }}" {{ request('class') == $cls ? 'selected' : '' }}>
                            {{ ucfirst($cls) }}
                        </option>
                    @endforeach
                </select>
                <select name="sort" class="catalog-select" onchange="this.form.submit()">
                    <option value="">По дате (новые)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена ↑</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена ↓</option>
                </select>
                @if(request()->hasAny(['class', 'sort']))
                    <a href="{{ route('catalog') }}" style="padding: 9px 16px; border: 1.5px solid #ddd; border-radius: 8px;
                                  background:#fff; font-size:13px; text-decoration:none; color: var(--smoke)">
                        Сбросить
                    </a>
                @endif
                <span style="margin-left:auto; color: var(--smoke); font-size:13px">
                    Найдено: {{ $animals->total() }}
                </span>
            </div>
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