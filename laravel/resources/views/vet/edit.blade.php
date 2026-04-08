@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 700px">
    <h2 class="mb-4">Редактировать запись #{{ $vetRecord->record_id }}</h2>

    <form method="POST" action="{{ route('vet.update', $vetRecord) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Животное *</label>
            <select name="animal_id" class="form-select" required>
                @foreach($animals as $a)
                    <option value="{{ $a->animal_id }}"
                        {{ old('animal_id', $vetRecord->animal_id) == $a->animal_id ? 'selected' : '' }}>
                        #{{ $a->animal_id }} — {{ $a->species->name }}
                        {{ $a->nickname ? '('.$a->nickname.')' : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ветеринар *</label>
            <select name="vet_id" class="form-select" required>
                @foreach($vets as $v)
                    <option value="{{ $v->employee_id }}"
                        {{ old('vet_id', $vetRecord->vet_id) == $v->employee_id ? 'selected' : '' }}>
                        {{ $v->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Дата *</label>
                <input type="date" name="record_date" class="form-control"
                    value="{{ old('record_date', $vetRecord->record_date) }}" required>
            </div>
            <div class="col mb-3">
                <label class="form-label">Тип *</label>
                <select name="record_type" class="form-select" required>
                    @foreach(['осмотр', 'прививка', 'лечение'] as $type)
                        <option value="{{ $type }}"
                            {{ old('record_type', $vetRecord->record_type) == $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Диагноз</label>
            <textarea name="diagnosis" class="form-control" rows="2">{{ old('diagnosis', $vetRecord->diagnosis) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Лечение / назначения</label>
            <textarea name="treatment" class="form-control" rows="2">{{ old('treatment', $vetRecord->treatment) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="form-label">Результат *</label>
            <select name="result" class="form-select" required>
                @foreach(['здоров', 'на лечении', 'карантин'] as $r)
                    <option value="{{ $r }}"
                        {{ old('result', $vetRecord->result) == $r ? 'selected' : '' }}>
                        {{ ucfirst($r) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="{{ route('vet.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection