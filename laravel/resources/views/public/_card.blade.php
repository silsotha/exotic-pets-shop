<div class="card animal-card h-100 shadow-sm">
    <a href="{{ route('catalog.show', $animal) }}" class="text-decoration-none text-dark">
        @if($animal->photo_url)
            <a href="{{ route('catalog.show', $animal) }}">
                <img src="{{ $animal->photo_url }}" alt="{{ $animal->species->name }}" class="card-img-top"
                    style="height:220px; object-fit:cover"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="no-photo" style="display:none">🐾</div>
            </a>
        @else
            <a href="{{ route('catalog.show', $animal) }}">
                <div class="no-photo">🐾</div>
            </a>
        @endif
    </a>
    <div class="card-body">
        <span class="badge bg-light text-secondary mb-1">{{ $animal->species->class }}</span>
        <h5 class="card-title mb-1">
            <a href="{{ route('catalog.show', $animal) }}" class="text-decoration-none text-dark">
                {{ $animal->species->name }}
            </a>
        </h5>
        @if($animal->nickname)
            <p class="text-muted small mb-2">{{ $animal->nickname }}</p>
        @endif
        <div class="d-flex justify-content-between align-items-center mt-auto pt-2">
            <span class="fs-5 fw-bold text-primary">
                {{ number_format($animal->sale_price, 0, '.', ' ') }} ₽
            </span>
            <a href="{{ route('catalog.show', $animal) }}" class="btn btn-sm btn-outline-primary">
                Подробнее
            </a>
        </div>
    </div>
</div>