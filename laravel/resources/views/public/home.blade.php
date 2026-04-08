@extends('layouts.public')
@section('title', 'Главная')

@section('content')

    <section class="hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">
                Магазин <span>экзотических</span> животных
            </h1>
            <p class="lead text-white-50 mb-4">
                Рептилии, амфибии, птицы и другие удивительные существа
            </p>
            <a href="{{ route('catalog') }}" class="btn btn-primary btn-lg px-5">
                Смотреть каталог
            </a>
        </div>
    </section>

    {{-- категории --}}
    @if($classes->count() > 0)
        <section class="py-5">
            <div class="container">
                <h2 class="text-center mb-4">Категории</h2>
                <div class="row justify-content-center g-3">
                    @foreach($classes as $class)
                        <div class="col-6 col-md-3 col-lg-2">
                            <a href="{{ route('catalog', ['class' => $class]) }}" class="btn btn-outline-secondary w-100 py-3">
                                @php
                                    $icons = [
                                        'рептилии' => '🦎',
                                        'амфибии' => '🐸',
                                        'птицы' => '🦜',
                                        'млекопитающие' => '🐿',
                                        'насекомые' => '🦗',
                                        'рыбы' => '🐟',
                                    ];
                                @endphp
                                <div class="fs-2">{{ $icons[$class] ?? '🐾' }}</div>
                                <div class="mt-1">{{ ucfirst($class) }}</div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="py-5 bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Новые поступления</h2>
                <a href="{{ route('catalog') }}" class="btn btn-outline-primary">Все животные →</a>
            </div>

            @if($newArrivals->count() > 0)
                <div class="row g-4">
                    @foreach($newArrivals as $animal)
                        <div class="col-sm-6 col-lg-4">
                            @include('public._card', ['animal' => $animal])
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted text-center py-4">Скоро появятся новые животные!</p>
            @endif
        </div>
    </section>

@endsection