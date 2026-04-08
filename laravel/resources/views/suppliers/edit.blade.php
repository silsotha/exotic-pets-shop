@extends('layouts.app')
@section('title', 'Редактировать поставщика')

@section('content')
    <div class="container py-4" style="max-width: 600px">
        <h2 class="mb-4">Редактировать: {{ $supplier->name }}</h2>

        <form method="POST" action="{{ route('suppliers.update', $supplier) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">Название организации *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Контактное лицо</label>
                <input type="text" name="contact_person" class="form-control"
                    value="{{ old('contact_person', $supplier->contact_person) }}">
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Телефон</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Номер лицензии</label>
                <input type="text" name="license_number" class="form-control"
                    value="{{ old('license_number', $supplier->license_number) }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection