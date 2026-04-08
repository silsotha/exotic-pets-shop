@extends('layouts.public')
@section('title', 'Каталог')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">Каталог животных</h1>

        {{-- фильтры --}}
        <form method="GET" class="row g-2 mb-4">
            <div class="col-sm-4 col-md-3">
                <select name="class" class="form-select">
                    <option value="">Все категории</option>
                    @foreach($classes as $cls)
                        <option value="{{ $cls }}" {{ request('class') == $cls ? 'selected' : '' }}>
                            {{ ucfirst($cls) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4 col-md-3">
                <select name="sort" class="form-select">
                    <option value="">По дате (новые)</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                        Цена: по возрастанию
                    </option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                        Цена: по убыванию
                    </option>
                </select>
            </div>
            <div class="col-sm-4 col-md-2">
                <button class="btn btn-primary w-100">Применить</button>
            </div>
            @if(request()->hasAny(['class', 'sort']))
                <div class="col-sm-4 col-md-2">
                    <a href="{{ route('catalog') }}" class="btn btn-outline-secondary w-100">Сбросить</a>
                </div>
            @endif
        </form>

        @if($animals->count() > 0)
            <div class="row g-4">
                @foreach($animals as $animal)
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        @include('public._card', ['animal' => $animal])
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $animals->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="fs-1">🔍</div>
                <p class="text-muted mt-2">Животных по вашему запросу не найдено</p>
                <a href="{{ route('catalog') }}" class="btn btn-outline-primary mt-2">Сбросить фильтры</a>
            </div>
        @endif
    </div>
@endsection