@extends('layouts.app')

@section('content')
    <div class="container py-4" style="max-width: 700px">
        <h2 class="mb-4">Редактировать животное</h2>

        <form method="POST" action="{{ route('animals.update', $animal) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Вид *</label>
                <select name="species_id" class="form-select @error('species_id') is-invalid @enderror" required>
                    @foreach($species as $s)
                        <option value="{{ $s->species_id }}" {{ old('species_id', $animal->species_id) == $s->species_id ? 'selected' : '' }}>
                            {{ $s->name }} ({{ $s->class }})
                        </option>
                    @endforeach
                </select>
                @error('species_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Поставщик *</label>
                <select name="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                    @foreach($suppliers as $s)
                        <option value="{{ $s->supplier_id }}" {{ old('supplier_id', $animal->supplier_id) == $s->supplier_id ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Кличка</label>
                    <input type="text" name="nickname" class="form-control"
                        value="{{ old('nickname', $animal->nickname) }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Пол *</label>
                    <select name="sex" class="form-select" required>
                        @foreach(['самец', 'самка', 'не определён'] as $option)
                            <option value="{{ $option }}" {{ old('sex', $animal->sex) == $option ? 'selected' : '' }}>
                                {{ ucfirst($option) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Дата рождения</label>
                    <input type="date" name="birth_date" class="form-control"
                        value="{{ old('birth_date', $animal->birth_date?->format('Y-m-d')) }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Дата поступления *</label>
                    <input type="date" name="arrival_date" class="form-control"
                        value="{{ old('arrival_date', $animal->arrival_date_formatted }}" required>
                </div>
            </div>

            {{-- статус — только для администратора --}}
            @if(auth()->user()->isAdmin())
                <div class="mb-3">
                    <label class="form-label">Статус *</label>
                    <select name="status" class="form-select" required>
                        @foreach(['карантин', 'на продажу', 'продано', 'списано'] as $s)
                            <option value="{{ $s }}" {{ old('status', $animal->status) == $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <input type="hidden" name="status" value="{{ $animal->status }}">
            @endif

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Закупочная цена (₽) *</label>
                    <input type="number" name="purchase_price" step="0.01" class="form-control"
                        value="{{ old('purchase_price', $animal->purchase_price) }}" required>
                </div>
                <div class="col mb-3">
                    <label class="form-label">Цена продажи (₽) *</label>
                    <input type="number" name="sale_price" step="0.01" class="form-control"
                        value="{{ old('sale_price', $animal->sale_price) }}" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Сертификат CITES</label>
                <input type="text" name="cites_certificate" class="form-control"
                    value="{{ old('cites_certificate', $animal->cites_certificate) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Фото (URL)</label>
                <input type="url" name="photo_url" class="form-control" value="{{ old('photo_url', $animal->photo_url) }}"
                    placeholder="https://example.com/photo.jpg">
                <div class="form-text">Вставьте прямую ссылку на изображение</div>
                <div id="photo-preview" class="mt-2" style="{{ $animal->photo_url ? '' : 'display:none' }}">
                    <img id="preview-img" src="{{ old('photo_url', $animal->photo_url) }}"
                        style="max-height: 200px; border-radius: 8px; border: 1px solid #dee2e6">
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                <a href="{{ route('animals.show', $animal) }}" class="btn btn-outline-secondary">Отмена</a>
            </div>
        </form>
        <script>
            document.querySelector('[name="photo_url"]').addEventListener('input', function () {
                const preview = document.getElementById('photo-preview');
                const img = document.getElementById('preview-img');
                if (this.value) {
                    img.src = this.value;
                    preview.style.display = 'block';
                } else {
                    preview.style.display = 'none';
                }
            });
        </script>
    </div>
@endsection