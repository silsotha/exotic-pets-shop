@extends('layouts.app')
@section('title', 'Сотрудники')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Сотрудники</h2>
            <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">+ Добавить</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ФИО</th>
                    <th>Роль</th>
                    <th>Телефон</th>
                    <th>Дата приёма</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $e)
                    <tr>
                        <td>{{ $e->full_name }}</td>
                        <td>
                            @php
                                $roleColors = [
                                    'администратор' => 'danger',
                                    'ветврач' => 'success',
                                    'продавец' => 'primary',
                                ];
                            @endphp
                            <span class="badge bg-{{ $roleColors[$e->role] ?? 'secondary' }}">
                                {{ $e->role }}
                            </span>
                        </td>
                        <td>{{ $e->phone ?? '—' }}</td>
                        <td>{{ $e->hire_date }}</td>
                        <td>
                            <a href="{{ route('admin.employees.edit', $e) }}" class="btn btn-sm btn-warning">
                                Изменить
                            </a>
                            <form method="POST" action="{{ route('admin.employees.destroy', $e) }}" class="d-inline"
                                onsubmit="return confirm('Удалить сотрудника?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Сотрудников нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $employees->links() }}
    </div>
@endsection