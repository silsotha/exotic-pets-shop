@extends('layouts.app')

@section('title', 'Поставщики')
@section('page-title', 'Поставщики')

@section('content')
    <section class="admin-section">
        <header class="admin-section-header">
            <div class="admin-section-heading">
                <div class="admin-section-eyebrow">
                    <i class="bi bi-truck"></i>
                    Поставки
                </div>

                <h1 class="admin-section-title">Поставщики</h1>

                <p class="admin-section-description">
                    Контактные данные, лицензии и количество животных от каждого поставщика.
                </p>
            </div>

            <div class="admin-section-actions">
                <a href="{{ route('admin.suppliers.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    Добавить поставщика
                </a>
            </div>
        </header>

        <div class="admin-panel">
            <div class="admin-panel-header">
                <div class="admin-panel-heading">
                    <h2 class="admin-panel-title">Список поставщиков</h2>

                    <p class="admin-panel-description">
                        Всего записей: {{ $suppliers->total() }}
                    </p>
                </div>
            </div>

            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Поставщик</th>
                            <th>Контактное лицо</th>
                            <th>Телефон</th>
                            <th>Email</th>
                            <th>Лицензия</th>
                            <th>Животных</th>
                            <th class="admin-table-actions-cell">Действия</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($suppliers as $s)
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        {{ $s->name }}
                                    </div>
                                </td>

                                <td>
                                    {{ $s->contact_person ?? '—' }}
                                </td>

                                <td class="admin-table-number">
                                    {{ $s->phone ?? '—' }}
                                </td>

                                <td>
                                    @if($s->email)
                                        <a href="mailto:{{ $s->email }}" class="text-decoration-none">
                                            {{ $s->email }}
                                        </a>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td>
                                    @if($s->license_number)
                                        <span class="admin-tag">
                                            {{ $s->license_number }}
                                        </span>
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="admin-table-number">
                                    {{ $s->animals_count ?? 0 }}
                                </td>

                                <td class="admin-table-actions-cell">
                                    <div class="admin-table-actions">
                                        <a
                                            href="{{ route('admin.suppliers.edit', $s) }}"
                                            class="admin-action-btn admin-action-edit"
                                            title="Редактировать"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            <span>Изменить</span>
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.suppliers.destroy', $s) }}"
                                            onsubmit="return confirm('Удалить поставщика?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="admin-action-btn admin-action-delete"
                                                title="Удалить"
                                            >
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="admin-empty-row">
                                <td colspan="7">
                                    <div class="admin-empty">
                                        <div class="admin-empty-icon">
                                            <i class="bi bi-truck"></i>
                                        </div>

                                        <div class="admin-empty-title">
                                            Поставщики не добавлены
                                        </div>

                                        <div>
                                            Добавь поставщика, чтобы привязывать его к поступлениям животных.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($suppliers->hasPages())
                <footer class="admin-panel-footer">
                    {{ $suppliers->links() }}
                </footer>
            @endif
        </div>
    </section>
@endsection