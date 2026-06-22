@php
    $selectedSpecies = collect(old(
        'species_ids',
        isset($feed)
            ? $feed->species->pluck('species_id')->all()
            : []
    ))->map(fn ($id) => (int) $id);

    $speciesGroups = $species->groupBy(
        fn ($item) =>
            $item->class . '|' .
            ($item->feeding_group ?: 'без группы')
    );
@endphp

<div class="mb-4" data-selection-scope="specific-species">
    <label class="form-label">
        Дополнительные конкретные виды
    </label>

    <p class="text-muted small mb-3">
        В каждой группе можно выбрать все виды одной галочкой
        или отметить только нужные.
    </p>

    <div class="feed-species-groups">
        @forelse($speciesGroups as $groupKey => $groupSpecies)
            @php
                [$animalClass, $feedingGroup] =
                    explode('|', $groupKey, 2);

                $selectionKey = 'species-' . \Illuminate\Support\Str::slug(
                    $animalClass . '-' . $feedingGroup
                );

                $allSpeciesSelected = $groupSpecies->every(
                    fn ($item) =>
                        $selectedSpecies->contains((int) $item->species_id)
                );
            @endphp

            <section
                class="feed-species-group"
                data-select-group="{{ $selectionKey }}"
            >
                <div class="feed-species-group-header">
                    <div>
                        <strong>{{ ucfirst($animalClass) }}</strong>
                        <span>→ {{ ucfirst($feedingGroup) }}</span>
                    </div>

                    <label class="feed-species-select-all">
                        <input
                            type="checkbox"
                            class="form-check-input js-select-all"
                            data-select-all="{{ $selectionKey }}"
                            {{ $allSpeciesSelected ? 'checked' : '' }}
                        >

                        <span>Все виды</span>
                    </label>
                </div>

                <div class="feed-species-options">
                    @foreach($groupSpecies as $item)
                        <label class="feed-species-option">
                            <input
                                id="species-{{ $item->species_id }}"
                                type="checkbox"
                                name="species_ids[]"
                                value="{{ $item->species_id }}"
                                class="form-check-input js-select-child"
                                data-select-child="{{ $selectionKey }}"
                                {{ $selectedSpecies->contains(
                                    (int) $item->species_id
                                ) ? 'checked' : '' }}
                            >

                            <span>{{ $item->name }}</span>
                        </label>
                    @endforeach
                </div>
            </section>
        @empty
            <div class="text-muted">
                Виды животных пока не добавлены.
            </div>
        @endforelse
    </div>

    @error('species_ids')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror

    @error('species_ids.*')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror
</div>
