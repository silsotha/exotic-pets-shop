@extends('layouts.app')
@section('title', 'Добавить сотрудника')

@section('content')
    <div class="container py-4" style="max-width: 550px">
        <h2 class="mb-4">Добавить сотрудника</h2>

        <form method="POST" action="{{ route('admin.employees.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">ФИО *</label>
                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror"
                    value="{{ old('full_name') }}" placeholder="Иванов Иван Иванович" required>
                @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Роль *</label>
                <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">— выберите —</option>
                    @foreach(['продавец', 'ветврач', 'администратор'] as $role)
                        <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Телефон</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}"
                    placeholder="+7 (920) 000-00-00">
            </div>

            <div class="mb-4">
                <label class="form-label">Дата приёма на работу *</label>
                <input type="date" name="hire_date" class="form-control" value="{{ old('hire_date', date('Y-m-d')) }}"
                    required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection