@php
    $classBg = [
        'рептилии' => 'reptile',
        'птицы' => 'bird',
        'насекомые' => 'insect',
        'амфибии' => 'amphibian',
        'млекопитающие' => 'reptile',
    ];
    $classIcon = [
        'рептилии' => '🦎',
        'птицы' => '🦜',
        'насекомые' => '🦋',
        'амфибии' => '🐸',
        'млекопитающие' => '🐭',
    ];
    $bg = $classBg[$animal->species->class] ?? 'reptile';
    $icon = $classIcon[$animal->species->class] ?? '🐾';
@endphp

<div class="animal-card" onclick="window.location='{{ route('catalog.show', $animal) }}'">
    <div class="animal-img {{ $bg }}">
        <span class="status-badge status-available">Доступно</span>
        @if($animal->photo_url)
            <img src="{{ $animal->photo_url }}" alt="{{ $animal->species->name }}"
                style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0"
                onerror="this.style.display='none'">
        @else
            {{ $icon }}
        @endif
    </div>
    <div class="animal-body">
        <div class="animal-species">{{ ucfirst($animal->species->class) }}</div>
        <div class="animal-name">{{ $animal->species->name }}</div>
        <div class="animal-meta">
            <span>
                @if($animal->sex === 'самец') ♂ Самец
                @elseif($animal->sex === 'самка') ♀ Самка
                @else Пол не определён
                @endif
            </span>
            @if($animal->birth_date)
                @php
                    $months = (int) $animal->birth_date->diffInMonths(now());
                    $age = $months < 12 ? $months . ' мес.' : floor($months / 12) . ' г.';
                @endphp
                <span>· {{ $age }}</span>
            @endif
            @if($animal->cites_certificate)
                <span>· CITES</span>
            @endif
        </div>
        <div class="animal-footer">
            <span class="animal-price">{{ number_format($animal->sale_price, 0, '.', ' ') }} ₽</span>
            <a href="{{ route('catalog.show', $animal) }}" class="btn-details"
                onclick="event.stopPropagation()">Подробнее</a>
        </div>
    </div>
</div>