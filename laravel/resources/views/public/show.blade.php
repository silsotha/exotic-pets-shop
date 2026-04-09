@extends('layouts.public')
@section('title', $animal->species->name)

@section('content')
<div class="pub-section">

    <div style="font-size:13px; color: var(--smoke); margin-bottom: 24px">
        <a href="{{ route('home') }}"    style="color: var(--sage); text-decoration:none">Главная</a>
        &nbsp;/&nbsp;
        <a href="{{ route('catalog') }}" style="color: var(--sage); text-decoration:none">Каталог</a>
        &nbsp;/&nbsp; {{ $animal->species->name }}
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: start">

        {{-- фото --}}
        <div>
            @php
                $classBg = ['рептилии'=>'reptile','птицы'=>'bird','насекомые'=>'insect','амфибии'=>'amphibian'];
                $classIcon = ['рептилии'=>'🦎','птицы'=>'🦜','насекомые'=>'🦋','амфибии'=>'🐸','млекопитающие'=>'🐭'];
                $bg   = $classBg[$animal->species->class]   ?? 'reptile';
                $icon = $classIcon[$animal->species->class] ?? '🐾';
            @endphp
            <div class="animal-img {{ $bg }}"
                 style="height:400px; border-radius:16px; font-size:120px">
                @if($animal->photo_url)
                    <img src="{{ $animal->photo_url }}"
                         style="width:100%;height:100%;object-fit:cover;position:absolute;inset:0;border-radius:16px"
                         onerror="this.style.display='none'">
                @else
                    {{ $icon }}
                @endif
                <span class="status-badge status-available">Доступно</span>
            </div>
        </div>

        {{-- инфо --}}
        <div>
            <div class="section-label">{{ ucfirst($animal->species->class) }}</div>
            <h1 style="font-family:'Playfair Display',serif; font-size:40px; color:var(--forest); margin: 8px 0">
                {{ $animal->species->name }}
            </h1>
            @if($animal->nickname)
                <p style="color:var(--smoke); margin-bottom:16px">Кличка: <em>{{ $animal->nickname }}</em></p>
            @endif

            <div style="font-size:36px; font-weight:700; color:var(--amber); margin: 20px 0">
                {{ number_format($animal->sale_price, 0, '.', ' ') }} ₽
            </div>

            <table style="width:100%; border-collapse:collapse; margin-bottom:24px">
                <tr>
                    <td style="padding:8px 0; color:var(--smoke); font-size:13px; width:40%">Пол</td>
                    <td style="padding:8px 0; font-size:13px">
                        @if($animal->sex === 'самец') ♂ Самец
                        @elseif($animal->sex === 'самка') ♀ Самка
                        @else Не определён
                        @endif
                    </td>
                </tr>
                @if($animal->birth_date)
                <tr>
                    <td style="padding:8px 0; color:var(--smoke); font-size:13px">Возраст</td>
                    <td style="padding:8px 0; font-size:13px">
                        @php
                            $months = (int) $animal->birth_date->diffInMonths(now());
                            if ($months < 12) {
                                $age = $months . ' мес.';
                            } else {
                                $years = floor($months / 12);
                                $rem   = $months % 12;
                                $age   = $years . ' г.' . ($rem > 0 ? ' ' . $rem . ' мес.' : '');
                            }
                        @endphp
                        {{ $age }}
                    </td>
                </tr>
                @endif
                @if($animal->species->habitat)
                <tr>
                    <td style="padding:8px 0; color:var(--smoke); font-size:13px">Родина</td>
                    <td style="padding:8px 0; font-size:13px">{{ $animal->species->habitat }}</td>
                </tr>
                @endif
                @if($animal->species->temp_min)
                <tr>
                    <td style="padding:8px 0; color:var(--smoke); font-size:13px">Температура</td>
                    <td style="padding:8px 0; font-size:13px">{{ $animal->species->temp_min }}°–{{ $animal->species->temp_max }}°C</td>
                </tr>
                @endif
                @if($animal->species->humidity_min)
                <tr>
                    <td style="padding:8px 0; color:var(--smoke); font-size:13px">Влажность</td>
                    <td style="padding:8px 0; font-size:13px">{{ $animal->species->humidity_min }}%–{{ $animal->species->humidity_max }}%</td>
                </tr>
                @endif
                @if($animal->cites_certificate)
                <tr>
                    <td style="padding:8px 0; color:var(--smoke); font-size:13px">Сертификат CITES</td>
                    <td style="padding:8px 0; font-size:13px"><code>{{ $animal->cites_certificate }}</code></td>
                </tr>
                @endif
            </table>

            <div class="alert-banner">
                ✅ Животное доступно для покупки. Свяжитесь с нами для оформления.
            </div>

            <div style="background:var(--cream); border:1.5px solid #e0d8cc; border-radius:12px; padding:20px; font-size:14px">
                <strong style="display:block; margin-bottom:10px; color:var(--forest)">Контакты магазина</strong>
                📞 +7 (920) 000-00-00<br>
                ✉ info@exoticpets.ru<br>
                📍 Москва, ул. Примерная, 1
            </div>
        </div>
    </div>

    {{-- похожие --}}
    @if($similar->count() > 0)
    <div style="margin-top: 64px">
        <div class="section-label">Похожие</div>
        <div class="section-title">Другие {{ $animal->species->name }}</div>
        <div class="animals-grid" style="grid-template-columns: repeat(3,1fr)">
            @foreach($similar as $s)
                @include('public._card', ['animal' => $s])
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection