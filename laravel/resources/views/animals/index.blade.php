@extends('layouts.app')

@section('title', 'Животные')
@section('page-title', 'Животные')

@section('content')
    <section class="admin-section">
        <header class="admin-section-header">
            <div class="admin-section-heading">
                <div class="admin-section-eyebrow">
                    <i class="bi bi-grid"></i>
                    Каталог
                </div>

                <h1 class="admin-section-title">Животные</h1>

                <p class="admin-section-description">
                    Управление животными, их статусами, стоимостью и доступностью для продажи.
                </p>
            </div>

            <div class="admin-section-actions">
                <a href="{{ route('animals.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    Добавить животное
                </a>
            </div>
        </header>

        <div class="admin-panel">
            <div class="admin-panel-header">
                <div class="admin-panel-heading">
                    <h2 class="admin-panel-title">Каталог животных</h2>

                    <p class="admin-panel-description">
                        Найдено записей: {{ $animals->total() }}
                    </p>
                </div>
            </div>

            <form method="GET" action="{{ route('animals.index') }}" class="admin-filters">
                <div class="admin-filter">
                    <label for="status" class="form-label">Статус</label>

                    <select id="status" name="status" class="form-select">
                        <option value="">Все статусы</option>

                        <option value="карантин" @selected(request('status') === 'карантин')>
                            Карантин
                        </option>

                        <option value="на продажу" @selected(request('status') === 'на продажу')>
                            На продажу
                        </option>

                        <option value="продано" @selected(request('status') === 'продано')>
                            Продано
                        </option>

                        <option value="списано" @selected(request('status') === 'списано')>
                            Списано
                        </option>
                    </select>
                </div>

                <div class="admin-filter">
                    <label for="species_id" class="form-label">Вид животного</label>

                    <select id="species_id" name="species_id" class="form-select">
                        <option value="">Все виды</option>

                        @foreach($species as $s)
                            <option
                                value="{{ $s->species_id }}"
                                @selected((string) request('species_id') === (string) $s->species_id)
                            >
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-filter-actions">
                    <button type="submit" class="btn btn-secondary">
                        <i class="bi bi-funnel"></i>
                        Применить
                    </button>

                    <a href="{{ route('animals.index') }}" class="btn btn-light">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Сбросить
                    </a>
                </div>
            </form>

            <div class="admin-table-scroll">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Животное</th>
                            <th>Пол</th>
                            <th>Статус</th>
                            <th>Цена продажи</th>
                            <th>Поступление</th>
                            <th class="admin-table-actions-cell">Действия</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($animals as $animal)
                            @php
                                $statusClasses = [
                                    'карантин' => 'admin-status-quarantine',
                                    'на продажу' => 'admin-status-sale',
                                    'продано' => 'admin-status-sold',
                                    'списано' => 'admin-status-written-off',
                                ];
                            @endphp

                            <tr>
                                <td class="admin-table-number">
                                    #{{ $animal->animal_id }}
                                </td>

                                <td>
                                    <div class="admin-table-primary">
                                        {{ $animal->nickname ?? $animal->species->name }}
                                    </div>

                                    <div class="admin-table-secondary">
                                        {{ $animal->species->name }}
                                    </div>
                                </td>

                                <td>
                                    {{ $animal->sex }}
                                </td>

                                <td>
                                    <span class="admin-status {{ $statusClasses[$animal->status] ?? 'admin-status-sold' }}">
                                        {{ $animal->status }}
                                    </span>
                                </td>

                                <td class="admin-table-number">
                                    {{ number_format($animal->sale_price, 2, ',', ' ') }} ₽
                                </td>

                                <td class="admin-table-number">
                                    {{ $animal->arrival_date_formatted }}
                                </td>

                                <td class="admin-table-actions-cell">
                                    <div class="admin-table-actions">
                                        <a
                                            href="{{ route('animals.show', $animal) }}"
                                            class="admin-action-btn admin-action-view"
                                            title="Открыть карточку"
                                        >
                                            <i class="bi bi-eye"></i>
                                            <span>Карточка</span>
                                        </a>

                                        <a
                                            href="{{ route('animals.edit', $animal) }}"
                                            class="admin-action-btn admin-action-edit"
                                            title="Редактировать"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        @if($animal->status === 'карантин')
                                            <form
                                                method="POST"
                                                action="{{ route('animals.approve', $animal) }}"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="admin-action-btn admin-action-confirm"
                                                    title="Перевести в продажу"
                                                >
                                                    <i class="bi bi-check-lg"></i>
                                                    <span>В продажу</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="admin-empty-row">
                                <td colspan="7">
                                    <div class="admin-empty">
                                        <div class="admin-empty-icon">
                                            <i class="bi bi-grid"></i>
                                        </div>

                                        <div class="admin-empty-title">
                                            Животные не найдены
                                        </div>

                                        <div>
                                            Измени параметры фильтра или добавь новое животное.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($animals->hasPages())
                <footer class="admin-panel-footer">
                    {{ $animals->withQueryString()->links() }}
                </footer>
            @endif
        </div>
    </section>
@endsection