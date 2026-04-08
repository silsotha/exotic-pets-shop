@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 600px">
    <h2 class="mb-4">Добавить клиента</h2>

    <form method="POST" action="{{ route('clients.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">ФИО *</label>
            <input type="text" name="full_name"
                class="form-control @error('full_name') is-invalid @enderror"
                value="{{ old('full_name') }}"
                placeholder="Иванов Иван Иванович"
                required>
            @error('full_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Телефон</label>
                <input type="text" name="phone"
                    class="form-control"
                    value="{{ old('phone') }}"
                    placeholder="+7 (___) ___-__-__">
            </div>
            <div class="col mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="example@mail.ru">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Серия и номер паспорта</label>
            <input type="text" name="passport_data"
                class="form-control"
                value="{{ old('passport_data') }}"
                placeholder="4516 123456">
            <div class="form-text">
                Требуется для оформления договора на животных с сертификатом CITES.
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection