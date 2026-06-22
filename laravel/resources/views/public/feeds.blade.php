@extends('layouts.public')

@section('title', 'Кормовые объекты')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public-feeds.css') }}">
@endpush

@section('content')
    <div class="pub-section feed-catalog-page">
        <div class="section-label">Рацион и уход</div>
        <h1 class="section-title">Кормовые объекты</h1>

        <p class="feed-page-intro">
            Подборка живых, замороженных, растительных и других кормов,
            связанных с конкретными видами животных.
        </p>

        <form method="GET" action="{{ route('feeds') }}" class="feed-filters">
            <select name="type" class="catalog-select">
                <option value="">Все типы корма</option>
                @foreach($feedTypes as $type)
                    <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>

            <select name="species" class="catalog-select">
                <option value="">Все виды животных</option>
                @foreach($species as $speciesItem)
                    <option
                        value="{{ $speciesItem->species_id }}"
                        {{ (string) request('species') === (string) $speciesItem->species_id ? 'selected' : '' }}
                    >
                        {{ $speciesItem->name }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn-primary feed-filter-submit">Применить</button>

            @if(request()->hasAny(['type', 'species']))
                <a href="{{ route('feeds') }}" class="catalog-reset">Сбросить</a>
            @endif
        </form>

        @if($feeds->count() > 0)
            <div class="feeds-grid">
                @foreach($feeds as $feed)
                    @include('public._feed-card', ['feed' => $feed])
                @endforeach
            </div>

            @if($feeds->hasPages())
                <div class="feed-pagination">{{ $feeds->links() }}</div>
            @endif
        @else
            <div class="feed-empty">Подходящих кормовых объектов пока нет.</div>
        @endif
    </div>
@endsection
