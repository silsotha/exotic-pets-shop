@extends('layouts.app')

@section('title', 'Кормовые объекты')
@section('page-title', 'Кормовые объекты')

@section('content')
    <section class="admin-section">
        <header class="admin-section-header">
            <div class="admin-section-heading">
                <div class="admin-section-eyebrow">
                    <i class="bi bi-box-seam"></i>
                    Справочник
                </div>

                <h1 class="admin-section-title">Кормовые объекты</h1>

                <p class="admin-section-description">
                    Корма, добавки, их назначение и подходящие виды животных.
                </p>
            </div>

            <div class="admin-section-actions">
                <a href="{{ route('admin.feeds.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    Добавить объект
                </a>
            </div>
        </header>

        <div class="admin-panel">
            <div class="admin-panel-header">
                <div class="admin-panel-heading">
                    <h2 class="admin-panel-title">Справочник кормов</h2>
                    <p class="admin-panel-description">
                        Всего записей: {{ $feeds->total() }}
                    </p>
                </div>
            </div>

            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Тип</th>
                            <th>Назначение</th>
                            <th>Подходящие виды</th>
                            <th>Остаток</th>
                            <th class="admin-table-actions-cell">Действия</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($feeds as $feed)
                            <tr>
                                <td>
                                    <div class="admin-table-primary">{{ $feed->name }}</div>

                                    @if($feed->rodent_stage_label || $feed->prey_weight_label)
                                        <div class="text-muted small mt-1">
                                            {{ $feed->rodent_stage_label }}

                                            @if($feed->prey_weight_label)
                                                · {{ $feed->prey_weight_label }}
                                            @endif
                                        </div>
                                    @endif

                                    @if($feed->description)
                                        <div class="text-muted small mt-1">
                                            {{ \Illuminate\Support\Str::limit($feed->description, 90) }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <span class="admin-tag">
                                        {{ $feed->feed_type ?: 'Не указан' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $feed->purpose
                                        ? \Illuminate\Support\Str::limit($feed->purpose, 100)
                                        : '—' }}
                                </td>

                                <td>
                                    @forelse($feed->species as $item)
                                        <span class="admin-tag d-inline-block mb-1">
                                            {{ $item->name }}
                                        </span>
                                    @empty
                                        <span class="text-muted">Не назначены</span>
                                    @endforelse
                                </td>

                                <td class="admin-table-number">
                                    {{ number_format((int) $feed->quantity_in_stock, 0, ',', ' ') }}
                                    {{ $feed->unit }}

                                    @if($feed->quantity_in_stock <= $feed->min_stock_level)
                                        <div class="text-danger small mt-1">Требуется пополнение</div>
                                    @endif
                                </td>

                                <td class="admin-table-actions-cell">
                                    <div class="admin-table-actions">
                                        <a
                                            href="{{ route('admin.feeds.edit', $feed) }}"
                                            class="admin-action-btn admin-action-edit"
                                            title="Редактировать"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            <span>Изменить</span>
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.feeds.destroy', $feed) }}"
                                            onsubmit="return confirm('Удалить этот кормовой объект?')"
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
                                <td colspan="6">
                                    <div class="admin-empty">
                                        <div class="admin-empty-icon">
                                            <i class="bi bi-box-seam"></i>
                                        </div>

                                        <div class="admin-empty-title">
                                            Кормовые объекты не добавлены
                                        </div>

                                        <div>
                                            Добавьте первый корм и укажите подходящие виды животных.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($feeds->hasPages())
                <footer class="admin-panel-footer">
                    {{ $feeds->links() }}
                </footer>
            @endif
        </div>
    </section>
@endsection
