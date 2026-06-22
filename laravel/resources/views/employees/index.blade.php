@extends('layouts.app')

@section('title', 'Сотрудники')
@section('page-title', 'Сотрудники')

@section('content')
    <section class="admin-section">
        <header class="admin-section-header">
            <div class="admin-section-heading">
                <div class="admin-section-eyebrow">
                    <i class="bi bi-person-badge"></i>
                    Персонал
                </div>

                <h1 class="admin-section-title">Сотрудники</h1>

                <p class="admin-section-description">
                    Управление аккаунтами администраторов, продавцов-консультантов и ветеринарных врачей.
                </p>
            </div>

            <div class="admin-section-actions">
                <a
                    href="{{ route('admin.employees.create') }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-person-plus"></i>
                    Добавить сотрудника
                </a>
            </div>
        </header>

        <div class="admin-panel">
            <div class="admin-panel-header">
                <div class="admin-panel-heading">
                    <h2 class="admin-panel-title">
                        Список сотрудников
                    </h2>

                    <p class="admin-panel-description">
                        Всего записей: {{ $employees->total() }}
                    </p>
                </div>
            </div>

            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Сотрудник</th>
                            <th>Роль</th>
                            <th>Телефон</th>
                            <th>Дата приёма</th>
                            <th class="admin-table-actions-cell">
                                Действия
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($employees as $employee)
                            @php
                                $roleClasses = [
                                    'администратор' => 'admin-role-administrator',
                                    'ветврач' => 'admin-role-vet',
                                    'продавец' => 'admin-role-seller',
                                ];

                                $roleLabels = [
                                    'администратор' => 'Администратор',
                                    'ветврач' => 'Ветеринар',
                                    'продавец' => 'Продавец',
                                ];
                            @endphp

                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        {{ $employee->full_name }}
                                    </div>

                                    <div class="admin-table-secondary">
                                        ID сотрудника: {{ $employee->employee_id }}
                                    </div>
                                </td>

                                <td>
                                    <span class="admin-role {{ $roleClasses[$employee->role] ?? 'admin-role-default' }}">
                                        {{ $roleLabels[$employee->role] ?? $employee->role }}
                                    </span>
                                </td>

                                <td class="admin-table-number">
                                    @if($employee->phone)
                                        <a
                                            href="tel:{{ $employee->phone }}"
                                            class="admin-table-link"
                                        >
                                            {{ $employee->phone }}
                                        </a>
                                    @else
                                        <span class="admin-table-secondary">Не указан</span>
                                    @endif
                                </td>

                                <td class="admin-table-number">
                                    {{ $employee->hire_date }}
                                </td>

                                <td class="admin-table-actions-cell">
                                    <div class="admin-table-actions">
                                        <a
                                            href="{{ route('admin.employees.edit', $employee) }}"
                                            class="admin-action-btn admin-action-edit"
                                            title="Редактировать сотрудника"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            <span>Изменить</span>
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.employees.destroy', $employee) }}"
                                            onsubmit="return confirm('Удалить сотрудника?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="admin-action-btn admin-action-delete"
                                                title="Удалить сотрудника"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="admin-empty-row">
                                <td colspan="5">
                                    <div class="admin-empty">
                                        <div class="admin-empty-icon">
                                            <i class="bi bi-person-badge"></i>
                                        </div>

                                        <div class="admin-empty-title">
                                            Сотрудники не добавлены
                                        </div>

                                        <div>
                                            Добавь сотрудника и назначь ему роль в системе.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($employees->hasPages())
                <footer class="admin-panel-footer">
                    {{ $employees->links() }}
                </footer>
            @endif
        </div>
    </section>
@endsection