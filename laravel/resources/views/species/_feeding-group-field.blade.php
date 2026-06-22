<div class="mb-3">
    <label for="feeding_group" class="form-label">
        Группа кормления *
    </label>

    <select
        id="feeding_group"
        name="feeding_group"
        class="form-select @error('feeding_group') is-invalid @enderror"
        data-current-value="{{ old(
            'feeding_group',
            $species->feeding_group ?? ''
        ) }}"
        required
    >
        <option value="">
            — сначала выберите класс —
        </option>
    </select>

    <div class="form-text">
        Например: рептилии → змеи или рептилии → гекконы.
    </div>

    @error('feeding_group')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const classSelect =
            document.querySelector('[name="class"]');

        const groupSelect =
            document.getElementById('feeding_group');

        const groups =
            @json(config('exotic.animal_groups', []));

        const initialValue =
            groupSelect.dataset.currentValue;

        const renderGroups = () => {
            const animalClass = classSelect?.value ?? '';
            const classGroups = groups[animalClass] ?? [];

            groupSelect.innerHTML =
                '<option value="">— выберите группу —</option>';

            classGroups.forEach(group => {
                const option =
                    document.createElement('option');

                option.value = group;
                option.textContent =
                    group.charAt(0).toUpperCase() +
                    group.slice(1);

                if (group === initialValue) {
                    option.selected = true;
                }

                groupSelect.appendChild(option);
            });

            groupSelect.disabled = classGroups.length === 0;
        };

        classSelect?.addEventListener(
            'change',
            () => {
                groupSelect.dataset.currentValue = '';
                renderGroups();
            }
        );

        renderGroups();
    });
</script>
@endpush
