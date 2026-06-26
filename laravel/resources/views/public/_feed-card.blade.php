@php
    $normalizedType = mb_strtolower($feed->feed_type ?? '');
    $normalizedName = mb_strtolower($feed->name ?? '');

    $typeClass = match (true) {
        str_contains($normalizedType, 'жив') => 'feed-type-live',
        str_contains($normalizedType, 'заморож') => 'feed-type-frozen',
        str_contains($normalizedType, 'раститель') => 'feed-type-plant',
        str_contains($normalizedType, 'сух') => 'feed-type-dry',
        str_contains($normalizedType, 'витамин'),
        str_contains($normalizedType, 'минерал'),
        str_contains($normalizedType, 'добав') => 'feed-type-supplement',
        default => 'feed-type-other',
    };

    $feedEmoji = match (true) {
        str_contains($normalizedName, 'сверч') => '🦗',
        str_contains($normalizedName, 'таракан') => '🪳',
        str_contains($normalizedName, 'мыш') => '🐁',
        str_contains($normalizedName, 'крыс') => '🐀',
        str_contains($normalizedName, 'саранч'),
        str_contains($normalizedName, 'кузнеч') => '🦗',
        str_contains($normalizedName, 'черв') => '🪱',
        str_contains($normalizedName, 'личин') => '🐛',
        str_contains($normalizedName, 'мучник') => '🐛',
        str_contains($normalizedName, 'рыб') => '🐟',
        str_contains($normalizedName, 'кревет') => '🦐',
        str_contains($normalizedName, 'цыпл'),
        str_contains($normalizedName, 'перепел') => '🐥',
        str_contains($normalizedName, 'ягод'),
        str_contains($normalizedName, 'фрукт') => '🍓',
        str_contains($normalizedName, 'овощ'),
        str_contains($normalizedName, 'зелень') => '🥬',
        $typeClass === 'feed-type-live' => '🦗',
        $typeClass === 'feed-type-frozen' => '❄️',
        $typeClass === 'feed-type-plant' => '🌿',
        $typeClass === 'feed-type-dry' => '🥣',
        $typeClass === 'feed-type-supplement' => '💊',
        default => '🍽️',
    };
@endphp

<article class="feed-card">
    <div class="feed-card-top">
        <div
            class="feed-card-icon {{ $typeClass }}"
            aria-hidden="true"
        >
            <span class="feed-card-emoji">{{ $feedEmoji }}</span>

            @if($typeClass === 'feed-type-frozen')
                <span class="feed-card-icon-corner">❄</span>
            @endif
        </div>

        <span class="feed-type-badge {{ $typeClass }}">
            {{ $feed->feed_type ?: 'Тип не указан' }}
        </span>
    </div>

    <h3 class="feed-card-title">{{ $feed->name }}</h3>

    @if($feed->rodent_stage_label || $feed->prey_weight_label)
        <div class="feed-rodent-meta">
            @if($feed->rodent_stage_label)
                <span>{{ $feed->rodent_stage_label }}</span>
            @endif

            @if($feed->prey_weight_label)
                <span>{{ $feed->prey_weight_label }}</span>
            @endif

            @include('public._stock-status', ['feed' => $feed])
        </div>
    @endif

    @if($feed->purpose)
        <p class="feed-card-purpose">
            {{ \Illuminate\Support\Str::limit($feed->purpose, 120) }}
        </p>
    @elseif($feed->description)
        <p class="feed-card-purpose">
            {{ \Illuminate\Support\Str::limit($feed->description, 120) }}
        </p>
    @endif

    @if($feed->species->isNotEmpty())
        <div class="feed-species-list">
            @foreach($feed->species->take(4) as $speciesItem)
                <span>{{ $speciesItem->name }}</span>
            @endforeach

            @if($feed->species->count() > 4)
                <span>+{{ $feed->species->count() - 4 }}</span>
            @endif
        </div>
    @endif
</article>
