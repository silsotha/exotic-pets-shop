@extends('layouts.app')

@section('content')
    <div class="container py-4" style="max-width: 700px">
        <h2 class="mb-4">Добавить животное</h2>

        <form method="POST" action="{{ route('animals.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Вид *</label>
                <select name="species_id" class="form-select @error('species_id') is-invalid @enderror" required>
                    <option value="">— выберите —</option>
                    @foreach($species as $s)
                        <option value="{{ $s->species_id }}" {{ old('species_id') == $s->species_id ? 'selected' : '' }}>
                            {{ $s->name }} ({{ $s->class }})
                        </option>
                    @endforeach
                </select>
                @error('species_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Поставщик *</label>
                <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                    <option value="">— выберите —</option>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->supplier_id }}" {{ old('supplier_id') == $s->supplier_id ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Кличка</label>
                    <input type="text" name="nickname" class="form-control" value="{{ old('nickname') }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Пол *</label>
                    <select name="sex" class="form-select @error('sex') is-invalid @enderror" required>
                        <option value="">— выберите —</option>
                        <option value="самец" {{ old('sex') == 'самец' ? 'selected' : '' }}>Самец</option>
                        <option value="самка" {{ old('sex') == 'самка' ? 'selected' : '' }}>Самка</option>
                        <option value="не определён" {{ old('sex') == 'не определён' ? 'selected' : '' }}>Не определён</option>
                    </select>
                    @error('sex')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Дата рождения</label>
                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Дата поступления *</label>
                    <input type="date" name="arrival_date" class="form-control"
                        value="{{ old('arrival_date', date('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Закупочная цена (₽) *</label>
                    <input type="number" name="purchase_price" step="0.01"
                        class="form-control @error('purchase_price') is-invalid @enderror"
                        value="{{ old('purchase_price') }}" required>
                    @error('purchase_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col mb-3">
                    <label class="form-label">Цена продажи (₽) *</label>
                    <input type="number" name="sale_price" step="0.01"
                        class="form-control @error('sale_price') is-invalid @enderror" value="{{ old('sale_price') }}"
                        required>
                    @error('sale_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Сертификат CITES</label>
                <input type="text" name="cites_certificate" class="form-control" value="{{ old('cites_certificate') }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection