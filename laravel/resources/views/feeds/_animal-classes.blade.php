@php
    $selectedClasses = old(
        'animal_classes',
        isset($feed) ? ($feed->animal_classes ?? []) : []
    );
@endphp

<div class="mb-4">
    <label class="form-label">Подходящие классы животных</label>

    <p class="text-muted small mb-3">
        Все существующие виды выбранных классов будут привязаны автоматически.
        Эта настройка также сохранится для новых видов.
    </p>

    <div class="feed-class-grid">
        @foreach($animalClasses as $class)
            <label
                for="class-{{ $loop->index }}"
                class="feed-class-option"
            >
                <input
                    id="class-{{ $loop->index }}"
                    type="checkbox"
                    name="animal_classes[]"
                    value="{{ $class }}"
                    class="form-check-input feed-class-checkbox"
                    data-animal-class="{{ $class }}"
                    {{ in_array($class, $selectedClasses, true) ? 'checked' : '' }}
                >

                <span class="feed-class-option-text">
                    {{ ucfirst($class) }}
                </span>
            </label>
        @endforeach
    </div>

    @error('animal_classes')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror

    @error('animal_classes.*')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror
</div>
