@extends('layouts.app')
@section('title', 'Добавить поставщика')

@section('content')
    <div class="container py-4" style="max-width: 600px">
        <h2 class="mb-4">Добавить поставщика</h2>

        <form method="POST" action="{{ route('admin.suppliers.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Название организации *</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}" placeholder="ООО «ЭкзотикТрейд»" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Контактное лицо</label>
                <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person') }}"
                    placeholder="Иванов Иван Иванович">
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Телефон</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                        placeholder="+7 (495) 123-45-67">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Номер лицензии</label>
                <input type="text" name="license_number" class="form-control" value="{{ old('license_number') }}"
                    placeholder="ЛИЦ-2024-00001">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.suppliers.index') }}" class="btn btn-outline-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection