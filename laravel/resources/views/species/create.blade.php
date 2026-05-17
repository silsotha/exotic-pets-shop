@extends('layouts.app')
@section('title', 'Добавить вид')

@section('content')
    <div class="container py-4" style="max-width: 650px">
        <h2 class="mb-4">Добавить вид животного</h2>

        <form method="POST" action="{{ route('admin.species.store') }}">
            @csrf

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Название *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="Пантеровый хамелеон" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col mb-3">
                    <label class="form-label">Класс *</label>
                    <select name="class" class="form-select @error('class') is-invalid @enderror" required>
                        <option value="">— выберите —</option>
                        @foreach(config('exotic.animal_classes') as $cls)
                            <option value="{{ $cls }}" {{ old('class') == $cls ? 'selected' : '' }}>
                                {{ ucfirst($cls) }}
                            </option>
                        @endforeach
                    </select>
                    @error('class')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Среда обитания</label>
                <input type="text" name="habitat" class="form-control" value="{{ old('habitat') }}"
                    placeholder="Мадагаскар, тропические леса">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Краткое описание вида</label>

                <textarea
                    id="description"
                    name="description"
                    rows="2"
                    class="form-control @error('description') is-invalid @enderror"
                    placeholder="Кратко опишите особенности вида, поведение, условия содержания..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="care_level" class="form-label">Уровень сложности содержания</label>

                <select id="care_level" name="care_level" class="form-select @error('care_level') is-invalid @enderror">
                    <option value="">— выберите —</option>

                    <option value="beginner" {{ old('care_level') === 'beginner' ? 'selected' : '' }}>
                        Подходит новичкам
                    </option>

                    <option value="intermediate" {{ old('care_level') === 'intermediate' ? 'selected' : '' }}>
                        Средняя сложность
                    </option>

                    <option value="advanced" {{ old('care_level') === 'advanced' ? 'selected' : '' }}>
                        Для опытных владельцев
                    </option>
                </select>

                @error('care_level')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Температура мин. (°C)</label>
                    <input type="number" name="temp_min" step="0.1" class="form-control" value="{{ old('temp_min') }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Температура макс. (°C)</label>
                    <input type="number" name="temp_max" step="0.1" class="form-control" value="{{ old('temp_max') }}">
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Влажность мин. (%)</label>
                    <input type="number" name="humidity_min" step="0.1" class="form-control"
                        value="{{ old('humidity_min') }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Влажность макс. (%)</label>
                    <input type="number" name="humidity_max" step="0.1" class="form-control"
                        value="{{ old('humidity_max') }}">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Срок карантина (дней) *</label>
                <input type="number" name="quarantine_days" class="form-control" value="{{ old('quarantine_days', 14) }}"
                    min="1" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.species.index') }}" class="btn btn-outline-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection