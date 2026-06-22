@extends('layouts.app')

@section('title', 'Ветеринарные записи')
@section('page-title', 'Ветеринарные записи')

@section('content')
    <section class="admin-section">
        <header class="admin-section-header">
            <div class="admin-section-heading">
                <div class="admin-section-eyebrow">
                    <i class="bi bi-heart-pulse"></i>
                    Ветеринария
                </div>

                <h1 class="admin-section-title">
                    Ветеринарные записи
                </h1>

                <p class="admin-section-description">
                    Осмотры, прививки, лечение и результаты ветеринарного наблюдения за животными.
                </p>
            </div>

            <div class="admin-section-actions">
                <a
                    href="{{ route('vet.create') }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-plus-lg"></i>
                    Добавить запись
                </a>
            </div>
        </header>

        @if(session('approve_animal_id'))
            <div class="admin-notice admin-notice-success">
                <div class="admin-notice-content">
                    <div class="admin-notice-icon">
                        <i class="bi bi-check-lg"></i>
                    </div>

                    <div>
                        <div class="admin-notice-title">
                            Осмотр успешно завершён
                        </div>

                        <div class="admin-notice-text">
                            Животное признано здоровым и может быть переведено в продажу.
                        </div>
                    </div>
                </div>

                <form
                    method="POST"
                    action="{{ route('animals.approve', session('approve_animal_id')) }}"
                >
                    @csrf
                    @method('PATCH')

                    <button
                        type="submit"
                        class="admin-action-btn admin-action-confirm"
                    >
                        <i class="bi bi-check-circle"></i>
                        Перевести в продажу
                    </button>
                </form>
            </div>
        @endif

        <div class="admin-panel">
            <div class="admin-panel-header">
                <div class="admin-panel-heading">
                    <h2 class="admin-panel-title">
                        Журнал ветеринарных записей
                    </h2>

                    <p class="admin-panel-description">
                        Найдено записей: {{ $records->total() }}
                    </p>
                </div>
            </div>

            <form
                method="GET"
                action="{{ route('vet.index') }}"
                class="admin-filters"
            >
                <div class="admin-filter">
                    <label for="record_type" class="form-label">
                        Тип записи
                    </label>

                    <select
                        id="record_type"
                        name="record_type"
                        class="form-select"
                    >
                        <option value="">
                            Все типы
                        </option>

                        <option
                            value="осмотр"
                            @selected(request('record_type') === 'осмотр')
                        >
                            Осмотр
                        </option>

                        <option
                            value="прививка"
                            @selected(request('record_type') === 'прививка')
                        >
                            Прививка
                        </option>

                        <option
                            value="лечение"
                            @selected(request('record_type') === 'лечение')
                        >
                            Лечение
                        </option>
                    </select>
                </div>

                <div class="admin-filter">
                    <label for="result" class="form-label">
                        Результат
                    </label>

                    <select
                        id="result"
                        name="result"
                        class="form-select"
                    >
                        <option value="">
                            Все результаты
                        </option>

                        <option
                            value="здоров"
                            @selected(request('result') === 'здоров')
                        >
                            Здоров
                        </option>

                        <option
                            value="на лечении"
                            @selected(request('result') === 'на лечении')
                        >
                            На лечении
                        </option>

                        <option
                            value="карантин"
                            @selected(request('result') === 'карантин')
                        >
                            Карантин
                        </option>
                    </select>
                </div>

                <div class="admin-filter-actions">
                    <button
                        type="submit"
                        class="btn btn-secondary"
                    >
                        <i class="bi bi-funnel"></i>
                        Применить
                    </button>

                    <a
                        href="{{ route('vet.index') }}"
                        class="btn btn-light"
                    >
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Сбросить
                    </a>
                </div>
            </form>

            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Животное</th>
                            <th>Тип записи</th>
                            <th>Диагноз</th>
                            <th>Результат</th>
                            <th>Ветеринар</th>
                            <th class="admin-table-actions-cell">
                                Действия
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($records as $record)
                            @php
                                $resultClasses = [
                                    'здоров' => 'admin-result-healthy',
                                    'на лечении' => 'admin-result-treatment',
                                    'карантин' => 'admin-result-quarantine',
                                ];

                                $typeIcons = [
                                    'осмотр' => 'bi-clipboard2-pulse',
                                    'прививка' => 'bi-shield-check',
                                    'лечение' => 'bi-capsule',
                                ];
                            @endphp

                            <tr>
                                <td class="admin-table-number">
                                    {{ $record->record_date }}
                                </td>

                                <td>
                                    @if($record->animal)
                                        <a
                                            href="{{ route('animals.show', $record->animal_id) }}"
                                            class="admin-entity-link"
                                        >
                                            <span class="admin-table-primary">
                                                {{ $record->animal->nickname ?? $record->animal->species?->name ?? 'Без клички' }}
                                            </span>

                                            <span class="admin-table-secondary">
                                                {{ $record->animal->species?->name ?? 'Неизвестный вид' }}
                                            </span>
                                        </a>
                                    @else
                                        <span class="admin-table-secondary">
                                            Животное не найдено
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="admin-record-type">
                                        <i class="bi {{ $typeIcons[$record->record_type] ?? 'bi-journal-medical' }}"></i>
                                        {{ ucfirst($record->record_type) }}
                                    </span>
                                </td>

                                <td>
                                    @if($record->diagnosis)
                                        <span
                                            class="admin-diagnosis"
                                            title="{{ $record->diagnosis }}"
                                        >
                                            {{ \Illuminate\Support\Str::limit($record->diagnosis, 42) }}
                                        </span>
                                    @else
                                        <span class="admin-table-secondary">
                                            Не указан
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="admin-result {{ $resultClasses[$record->result] ?? 'admin-result-default' }}">
                                        {{ ucfirst($record->result) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $record->vet->full_name }}
                                </td>

                                <td class="admin-table-actions-cell">
                                    <div class="admin-table-actions">
                                        <a
                                            href="{{ route('vet.show', $record->record_id) }}"
                                            class="admin-action-btn admin-action-view"
                                            title="Открыть запись"
                                        >
                                            <i class="bi bi-eye"></i>
                                            <span>Просмотр</span>
                                        </a>

                                        <a
                                            href="{{ route('vet.edit', $record->record_id) }}"
                                            class="admin-action-btn admin-action-edit"
                                            title="Редактировать запись"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('vet.destroy', $record) }}"
                                            onsubmit="return confirm('Удалить ветеринарную запись?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="admin-action-btn admin-action-delete"
                                                title="Удалить запись"
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
                                            <i class="bi bi-heart-pulse"></i>
                                        </div>

                                        <div class="admin-empty-title">
                                            Ветеринарные записи не найдены
                                        </div>

                                        <div>
                                            Измени параметры фильтра или создай новую запись.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($records->hasPages())
                <footer class="admin-panel-footer">
                    {{ $records->withQueryString()->links() }}
                </footer>
            @endif
        </div>
    </section>
@endsection