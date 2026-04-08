@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Ветеринарные записи</h2>
        <a href="{{ route('vet.create') }}" class="btn btn-primary">+ Добавить запись</a>
    </div>

    {{-- Уведомления --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            @if(session('approve_animal_id'))
                <form method="POST"
                      action="{{ route('animals.approve', session('approve_animal_id')) }}"
                      class="d-inline">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm btn-success ms-2">
                        Перевести на продажу
                    </button>
                </form>
            @endif
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Фильтры --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="record_type" class="form-select">
                <option value="">Все типы</option>
                <option value="осмотр"   {{ request('record_type') == 'осмотр'   ? 'selected' : '' }}>Осмотр</option>
                <option value="прививка" {{ request('record_type') == 'прививка' ? 'selected' : '' }}>Прививка</option>
                <option value="лечение"  {{ request('record_type') == 'лечение'  ? 'selected' : '' }}>Лечение</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="result" class="form-select">
                <option value="">Все результаты</option>
                <option value="здоров"     {{ request('result') == 'здоров'     ? 'selected' : '' }}>Здоров</option>
                <option value="на лечении" {{ request('result') == 'на лечении' ? 'selected' : '' }}>На лечении</option>
                <option value="карантин"   {{ request('result') == 'карантин'   ? 'selected' : '' }}>Карантин</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary w-100">Фильтр</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('vet.index') }}" class="btn btn-outline-danger w-100">Сбросить</a>
        </div>
    </form>

    {{-- Таблица --}}
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Дата</th>
                <th>Животное</th>
                <th>Тип</th>
                <th>Диагноз</th>
                <th>Результат</th>
                <th>Ветеринар</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $rec)
            <tr>
                <td>{{ $rec->record_date }}</td>
                <td>
                    @if($rec->animal)
                        <a href="{{ route('animals.show', $rec->animal_id) }}">
                            {{ $rec->animal->species?->name ?? 'Неизвестный вид' }}
                            {{ $rec->animal->nickname ? '('.$rec->animal->nickname.')' : '' }}
                        </a>
                    @else
                        <span class="text-muted">Животное не найдено</span>
                    @endif
                </td>
                <td>{{ $rec->record_type }}</td>
                <td>{{ Str::limit($rec->diagnosis, 40) ?? '—' }}</td>
                <td>
                    @php
                        $badges = [
                            'здоров'     => 'success',
                            'на лечении' => 'warning',
                            'карантин'   => 'danger',
                        ];
                    @endphp
                    <span class="badge bg-{{ $badges[$rec->result] ?? 'secondary' }}">
                        {{ $rec->result }}
                    </span>
                </td>
                <td>{{ $rec->vet->full_name }}</td>
                <td>
                    <a href="{{ route('vet.show', $rec->record_id) }}" class="btn btn-sm btn-info">Просмотр</a>
                    <a href="{{ route('vet.edit', $rec->record_id) }}" class="btn btn-sm btn-warning">Изменить</a>
                    <form method="POST" action="{{ route('vet.destroy', $rec) }}" class="d-inline"
                          onsubmit="return confirm('Удалить запись?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">Записей не найдено</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $records->withQueryString()->links() }}
</div>
@endsection