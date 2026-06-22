@php
    $selectedClasses = collect(old(
        'animal_classes',
        isset($feed) ? ($feed->animal_classes ?? []) : []
    ));

    $selectedGroups = collect(old(
        'animal_groups',
        isset($feed) ? ($feed->animal_groups ?? []) : []
    ));
@endphp

<div class="mb-4" data-selection-scope="animal-targets">
    <label class="form-label">Подходящие группы животных</label>

    <p class="text-muted small mb-3">
        Галочка «Все» выбирает или снимает все группы внутри класса.
        При частичном выборе она отображается в промежуточном состоянии.
    </p>

    <div class="feed-target-accordion">
        @foreach($animalClasses as $class)
            @php
                $groups = collect($animalGroups->get($class, []));

                $allGroupsSelected =
                    $groups->isNotEmpty() &&
                    $groups->every(
                        fn ($group) => $selectedGroups->contains($group)
                    );

                $classSelected =
                    $selectedClasses->contains($class) ||
                    $allGroupsSelected;
            @endphp

            <section
                class="feed-target-class"
                data-select-group="{{ $class }}"
            >
                <div class="feed-target-class-header">
                    <label class="feed-target-all">
                        <input
                            type="checkbox"
                            name="animal_classes[]"
                            value="{{ $class }}"
                            class="form-check-input js-select-all"
                            data-select-all="{{ $class }}"
                            {{ $classSelected ? 'checked' : '' }}
                        >

                        <span>Все: {{ ucfirst($class) }}</span>
                    </label>
                </div>

                @if($groups->isNotEmpty())
                    <div class="feed-target-groups">
                        @foreach($groups as $group)
                            <label class="feed-target-group">
                                <input
                                    type="checkbox"
                                    name="animal_groups[]"
                                    value="{{ $group }}"
                                    class="form-check-input js-select-child"
                                    data-select-child="{{ $class }}"
                                    {{ $selectedGroups->contains($group) ? 'checked' : '' }}
                                >

                                <span>{{ ucfirst($group) }}</span>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="feed-target-no-groups">
                        Для этого класса отдельные группы не заданы.
                    </div>
                @endif
            </section>
        @endforeach
    </div>

    @error('animal_classes')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror

    @error('animal_classes.*')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror

    @error('animal_groups')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror

    @error('animal_groups.*')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror
</div>
