@php
    $selectedSpecies = collect(
        old(
            'species_ids',
            isset($feed)
                ? $feed->species->pluck('species_id')->all()
                : []
        )
    )->map(
        fn ($id) => (int) $id
    )->all();
@endphp

<div class="row">
    <div class="col-md-7 mb-3">
        <label for="name" class="form-label">
            Название *
        </label>

        <input
            id="name"
            type="text"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $feed->name ?? '') }}"
            placeholder="Сверчок домовый"
            required
        >

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-5 mb-3">
        <label for="feed_type" class="form-label">
            Тип корма *
        </label>

        <select
            id="feed_type"
            name="feed_type"
            class="form-select @error('feed_type') is-invalid @enderror"
            required
        >
            <option value="">— выберите —</option>

            @foreach([
                'Живой корм',
                'Замороженный корм',
                'Растительный корм',
                'Сухой корм',
                'Минеральная добавка',
                'Витаминная добавка',
            ] as $type)
                <option
                    value="{{ $type }}"
                    {{ old('feed_type', $feed->feed_type ?? '') === $type ? 'selected' : '' }}
                >
                    {{ $type }}
                </option>
            @endforeach
        </select>

        @error('feed_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

@include('feeds._rodent-fields')

<div class="mb-3">
    <label for="description" class="form-label">
        Описание
    </label>

    <textarea
        id="description"
        name="description"
        rows="4"
        class="form-control @error('description') is-invalid @enderror"
        placeholder="Размер, состав, форма хранения и другие особенности..."
    >{{ old('description', $feed->description ?? '') }}</textarea>

    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="purpose" class="form-label">
        Назначение
    </label>

    <textarea
        id="purpose"
        name="purpose"
        rows="3"
        class="form-control @error('purpose') is-invalid @enderror"
        placeholder="Основной рацион, подкормка, восстановление..."
    >{{ old('purpose', $feed->purpose ?? '') }}</textarea>

    @error('purpose')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@include('feeds._animal-targets')

@include('feeds._specific-species')

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="unit" class="form-label">
            Единица учёта *
        </label>

        <select
            id="unit"
            name="unit"
            class="form-select @error('unit') is-invalid @enderror"
            required
        >
            <option value="">— выберите —</option>

            @foreach($feedUnits as $value => $label)
                <option
                    value="{{ $value }}"
                    {{ old('unit', $feed->unit ?? '') === $value ? 'selected' : '' }}
                >
                    {{ $label }} ({{ $value }})
                </option>
            @endforeach
        </select>

        @error('unit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label
            for="quantity_in_stock"
            class="form-label"
        >
            Начальный остаток *
        </label>

        <input
            id="quantity_in_stock"
            type="number"
            name="quantity_in_stock"
            min="0"
            step="1"
            inputmode="numeric"
            class="form-control @error('quantity_in_stock') is-invalid @enderror"
            value="{{ old(
                'quantity_in_stock',
                $feed->quantity_in_stock ?? 0
            ) }}"
            required
        >

        @error('quantity_in_stock')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label
            for="min_stock_level"
            class="form-label"
        >
            Минимальный остаток *
        </label>

        <input
            id="min_stock_level"
            type="number"
            name="min_stock_level"
            min="0"
            step="1"
            inputmode="numeric"
            class="form-control @error('min_stock_level') is-invalid @enderror"
            value="{{ old(
                'min_stock_level',
                $feed->min_stock_level ?? 0
            ) }}"
            required
        >

        @error('min_stock_level')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-lg"></i>
        Сохранить
    </button>

    <a
        href="{{ route('admin.feeds.index') }}"
        class="btn btn-outline-secondary"
    >
        Отмена
    </a>
</div>
