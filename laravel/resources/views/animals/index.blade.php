@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Животные</h2>
            <a href="{{ route('animals.create') }}" class="btn btn-primary">+ Добавить</a>
        </div>

        {{-- фильтры --}}
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Все статусы</option>
                    <option value="карантин" {{ request('status') == 'карантин' ? 'selected' : '' }}>Карантин</option>
                    <option value="на продажу" {{ request('status') == 'на продажу' ? 'selected' : '' }}>На продажу</option>
                    <option value="продано" {{ request('status') == 'продано' ? 'selected' : '' }}>Продано</option>
                    <option value="списано" {{ request('status') == 'списано' ? 'selected' : '' }}>Списано</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="species_id" class="form-select">
                    <option value="">Все виды</option>
                    @foreach($species as $s)
                        <option value="{{ $s->species_id }}" {{ request('species_id') == $s->species_id ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100">Фильтр</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('animals.index') }}" class="btn btn-outline-danger w-100">Сбросить</a>
            </div>
        </form>

        {{-- уведомления --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- таблица --}}
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Вид</th>
                    <th>Кличка</th>
                    <th>Пол</th>
                    <th>Статус</th>
                    <th>Цена продажи</th>
                    <th>Поступление</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($animals as $animal)
                    <tr>
                        <td>{{ $animal->animal_id }}</td>
                        <td>{{ $animal->species->name }}</td>
                        <td>{{ $animal->nickname ?? '—' }}</td>
                        <td>{{ $animal->sex }}</td>
                        <td>
                            @php
                                $badges = [
                                    'карантин' => 'warning',
                                    'на продажу' => 'success',
                                    'продано' => 'secondary',
                                    'списано' => 'dark',
                                ];
                            @endphp
                            <span class="badge bg-{{ $badges[$animal->status] ?? 'light' }}">
                                {{ $animal->status }}
                            </span>
                        </td>
                        <td>{{ number_format($animal->sale_price, 2) }} ₽</td>
                        <td>{{ $animal->arrival_date }}</td>
                        <td>
                            <a href="{{ route('animals.show', $animal) }}" class="btn btn-sm btn-info">Карточка</a>
                            <a href="{{ route('animals.edit', $animal) }}" class="btn btn-sm btn-warning">Изменить</a>
                            @if($animal->status === 'карантин')
                                <form method="POST" action="{{ route('animals.approve', $animal) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-success">✓ На продажу</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Животных не найдено</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $animals->withQueryString()->links() }}
    </div>
@endsection