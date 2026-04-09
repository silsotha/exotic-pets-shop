@extends('layouts.app')
@section('title', 'Редактировать сотрудника')

@section('content')
    <div class="container py-4" style="max-width: 550px">
        <h2 class="mb-4">Редактировать: {{ $employee->full_name }}</h2>

        <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label">ФИО *</label>
                <input type="text" name="full_name" class="form-control"
                    value="{{ old('full_name', $employee->full_name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Роль *</label>
                <select name="role" class="form-select" required>
                    @foreach(['продавец', 'ветврач', 'администратор'] as $role)
                        <option value="{{ $role }}" {{ old('role', $employee->role) == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Телефон</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone) }}">
            </div>

            <div class="mb-4">
                <label class="form-label">Дата приёма *</label>
                <input type="date" name="hire_date" class="form-control"
                    value="{{ old('hire_date', $employee->hire_date) }}" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection