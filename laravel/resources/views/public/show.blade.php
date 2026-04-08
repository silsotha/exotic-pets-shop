@extends('layouts.public')
@section('title', $animal->species->name)

@section('content')
    <div class="container py-5">

        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
                <li class="breadcrumb-item"><a href="{{ route('catalog') }}">Каталог</a></li>
                <li class="breadcrumb-item active">{{ $animal->species->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">

            {{-- фото --}}
            <div class="col-md-5">
                @if($animal->photo_url)
                    <img src="{{ $animal->photo_url }}" alt="{{ $animal->species->name }}" class="img-fluid rounded-3 shadow"
                        style="width:100%; max-height:450px; object-fit:cover">
                @else
                    <div class="rounded-3 bg-light d-flex align-items-center justify-content-center"
                        style="height:350px; font-size:6rem">
                        🐾
                    </div>
                @endif
            </div>

            {{-- инфо --}}
            <div class="col-md-7">
                <span class="badge bg-secondary mb-2">{{ $animal->species->class }}</span>
                <h1 class="mb-1">{{ $animal->species->name }}</h1>
                @if($animal->nickname)
                    <p class="text-muted">Кличка: <em>{{ $animal->nickname }}</em></p>
                @endif

                <div class="display-6 text-primary fw-bold my-3">
                    {{ number_format($animal->sale_price, 0, '.', ' ') }} ₽
                </div>

                <table class="table table-sm w-auto mb-4">
                    <tr>
                        <th class="pe-4">Пол</th>
                        <td>{{ ucfirst($animal->sex) }}</td>
                    </tr>
                    @if($animal->birth_date)
                        <tr>
                            <th>Возраст</th>
                            <td>
                                @php
                                    $months = (int) $animal->birth_date->diffInMonths(now());
                                    if ($months < 1) {
                                        echo 'менее месяца';
                                    } elseif ($months < 24) {
                                        echo $months . ' ' . trans_choice(
                                            'мес.|мес.|мес.',
                                            $months % 12
                                        );
                                    } else {
                                        $years = floor($months / 12);
                                        echo $years . ' ' . trans_choice('год|года|лет', $years);
                                    }
                                @endphp
                            </td>
                        </tr>
                    @endif
                    @if($animal->species->habitat)
                        <tr>
                            <th>Родина</th>
                            <td>{{ $animal->species->habitat }}</td>
                        </tr>
                    @endif
                    @if($animal->species->temp_min)
                        <tr>
                            <th>Температура</th>
                            <td>{{ $animal->species->temp_min }}°—{{ $animal->species->temp_max }}°C</td>
                        </tr>
                    @endif
                    @if($animal->species->humidity_min)
                        <tr>
                            <th>Влажность</th>
                            <td>{{ $animal->species->humidity_min }}%—{{ $animal->species->humidity_max }}%</td>
                        </tr>
                    @endif
                    @if($animal->cites_certificate)
                        <tr>
                            <th>CITES</th>
                            <td><code>{{ $animal->cites_certificate }}</code></td>
                        </tr>
                    @endif
                </table>

                <div class="alert alert-success d-inline-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i>
                    Доступно для покупки
                </div>

                <div class="mt-3 p-3 bg-light rounded">
                    <strong>Для покупки свяжитесь с нами:</strong><br>
                    📞 +7 (495) 000-00-00<br>
                    ✉ info@exoticpets.ru
                </div>
            </div>
        </div>

        {{-- похожие --}}
        @if($similar->count() > 0)
            <div class="mt-5">
                <h3 class="mb-3">Похожие животные</h3>
                <div class="row g-4">
                    @foreach($similar as $s)
                        <div class="col-sm-6 col-md-4">
                            @include('public._card', ['animal' => $s])
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection