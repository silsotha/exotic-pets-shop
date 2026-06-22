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

<a
    href="{{ route('catalog.show', $animal) }}"
    class="animal-card"
>
    <div class="animal-img {{ $bg }}">
        <span class="status-badge status-available">
            Доступно
        </span>

        <span class="animal-placeholder-icon" aria-hidden="true">
            {{ $icon }}
        </span>

        @if($animal->photo_url)
            <img
                src="{{ $animal->photo_url }}"
                alt="{{ $animal->species->name }}"
                class="animal-photo"
                loading="lazy"
                onerror="this.remove()"
            >
        @endif
    </div>

    <div class="animal-body">
        <div class="animal-species">
            {{ ucfirst($animal->species->class) }}
        </div>

        <div class="animal-title-row">
            <div class="animal-name">
                {{ $animal->species->name }}
            </div>

            @if($animal->species->care_level)
                <span class="care-badge care-badge-{{ $animal->species->care_level }}">
                    {{ $animal->species->care_level_label }}
                </span>
            @endif
        </div>

        <div class="animal-meta">
            <span>
                @if($animal->sex === 'самец')
                    ♂ Самец
                @elseif($animal->sex === 'самка')
                    ♀ Самка
                @else
                    Пол не определён
                @endif
            </span>

            @if($animal->birth_date)
                @php
                    $months = (int) $animal->birth_date->diffInMonths(now());

                    $age = $months < 12
                        ? $months . ' мес.'
                        : floor($months / 12) . ' г.';
                @endphp

                <span>· {{ $age }}</span>
            @endif

            @if($animal->cites_certificate)
                <span>· CITES</span>
            @endif
        </div>

        <div class="animal-footer">
            <span class="animal-price">
                {{ number_format($animal->sale_price, 0, '.', ' ') }} ₽
            </span>

            <span class="btn-details">
                Подробнее
            </span>
        </div>
    </div>
</a>