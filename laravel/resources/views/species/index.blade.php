@extends('layouts.app')

@section('title', 'Виды животных')
@section('page-title', 'Виды животных')

@section('content')
    <section class="admin-section">
        <header class="admin-section-header">
            <div class="admin-section-heading">
                <div class="admin-section-eyebrow">
                    <i class="bi bi-bookmarks"></i>
                    Справочник
                </div>

                <h1 class="admin-section-title">Виды животных</h1>

                <p class="admin-section-description">
                    Параметры содержания, карантина и среды обитания для разных видов животных.
                </p>
            </div>

            <div class="admin-section-actions">
                <a href="{{ route('admin.species.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    Добавить вид
                </a>
            </div>
        </header>

        <div class="admin-panel">
            <div class="admin-panel-header">
                <div class="admin-panel-heading">
                    <h2 class="admin-panel-title">Справочник видов</h2>

                    <p class="admin-panel-description">
                        Всего записей: {{ $species->total() }}
                    </p>
                </div>
            </div>

            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Класс</th>
                            <th>Среда обитания</th>
                            <th>Температура</th>
                            <th>Влажность</th>
                            <th>Карантин</th>
                            <th>Животных</th>
                            <th class="admin-table-actions-cell">Действия</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($species as $s)
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        {{ $s->name }}
                                    </div>
                                </td>

                                <td>
                                    <span class="admin-tag">
                                        {{ $s->class }}
                                    </span>
                                </td>

                                <td>
                                    {{ $s->habitat ?? '—' }}
                                </td>

                                <td class="admin-table-number">
                                    @if($s->temp_min !== null || $s->temp_max !== null)
                                        {{ $s->temp_min ?? '—' }}° — {{ $s->temp_max ?? '—' }}°
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="admin-table-number">
                                    @if($s->humidity_min !== null || $s->humidity_max !== null)
                                        {{ $s->humidity_min ?? '—' }}% — {{ $s->humidity_max ?? '—' }}%
                                    @else
                                        —
                                    @endif
                                </td>

                                <td class="admin-table-number">
                                    {{ $s->quarantine_days }} дн.
                                </td>

                                <td class="admin-table-number">
                                    {{ $s->animals_count ?? 0 }}
                                </td>

                                <td class="admin-table-actions-cell">
                                    <div class="admin-table-actions">
                                        <a
                                            href="{{ route('admin.species.edit', $s) }}"
                                            class="admin-action-btn admin-action-edit"
                                            title="Редактировать"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            <span>Изменить</span>
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.species.destroy', $s) }}"
                                            onsubmit="return confirm('Удалить этот вид?')"
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
                                <td colspan="8">
                                    <div class="admin-empty">
                                        <div class="admin-empty-icon">
                                            <i class="bi bi-bookmarks"></i>
                                        </div>

                                        <div class="admin-empty-title">
                                            Виды животных не добавлены
                                        </div>

                                        <div>
                                            Создай первый вид для использования в карточках животных.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($species->hasPages())
                <footer class="admin-panel-footer">
                    {{ $species->links() }}
                </footer>
            @endif
        </div>
    </section>
@endsection