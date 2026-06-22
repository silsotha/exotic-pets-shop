@php
    $currentName = old('name', $feed->name ?? '');
    $normalizedName = mb_strtolower($currentName);

    $isRodentFeed =
        str_contains($normalizedName, 'мыш') ||
        str_contains($normalizedName, 'крыс');
@endphp

<section
    id="rodentFeedFields"
    class="rodent-feed-fields {{ $isRodentFeed ? '' : 'd-none' }}"
>
    <div class="rodent-feed-fields-heading">
        <div>
            <h3>Параметры кормового грызуна</h3>
            <p>
                Остаток ниже будет означать количество животных именно этой
                стадии и массы.
            </p>
        </div>

        <span class="rodent-feed-icon" aria-hidden="true">🐁</span>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="rodent_stage" class="form-label">
                Стадия *
            </label>

            <select
                id="rodent_stage"
                name="rodent_stage"
                class="form-select @error('rodent_stage') is-invalid @enderror"
                data-rodent-required
            >
                <option value="">— выберите —</option>

                @foreach($rodentStages as $value => $label)
                    <option
                        value="{{ $value }}"
                        {{ old('rodent_stage', $feed->rodent_stage ?? '') === $value ? 'selected' : '' }}
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            @error('rodent_stage')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="prey_weight_min" class="form-label">
                Масса от, г *
            </label>

            <input
                id="prey_weight_min"
                type="number"
                name="prey_weight_min"
                min="1"
                max="500"
                step="1"
                class="form-control @error('prey_weight_min') is-invalid @enderror"
                value="{{ old('prey_weight_min', $feed->prey_weight_min ?? '') }}"
                data-rodent-required
            >

            @error('prey_weight_min')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-4 mb-3">
            <label for="prey_weight_max" class="form-label">
                Масса до, г *
            </label>

            <input
                id="prey_weight_max"
                type="number"
                name="prey_weight_max"
                min="1"
                max="500"
                step="1"
                class="form-control @error('prey_weight_max') is-invalid @enderror"
                value="{{ old('prey_weight_max', $feed->prey_weight_max ?? '') }}"
                data-rodent-required
            >

            @error('prey_weight_max')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const nameInput = document.getElementById('name');
        const fields = document.getElementById('rodentFeedFields');
        const requiredFields = fields?.querySelectorAll('[data-rodent-required]') ?? [];

        const isRodentName = value => {
            const normalized = value.trim().toLocaleLowerCase('ru-RU');

            return normalized.includes('мыш') || normalized.includes('крыс');
        };

        const syncRodentFields = () => {
            const visible = isRodentName(nameInput?.value ?? '');

            fields?.classList.toggle('d-none', !visible);

            requiredFields.forEach(field => {
                field.required = visible;
            });
        };

        nameInput?.addEventListener('input', syncRodentFields);
        syncRodentFields();
    });
</script>
@endpush
