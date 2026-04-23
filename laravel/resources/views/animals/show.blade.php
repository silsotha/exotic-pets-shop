@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- заголовок --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $animal->species->name }} — {{ $animal->nickname ?? 'без клички' }}</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('animals.edit', $animal) }}" class="btn btn-warning">Редактировать</a>
            <a href="{{ route('animals.index') }}" class="btn btn-outline-secondary">← Назад</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">

        {{-- основная информация --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header fw-bold">Основные данные</div>
                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr><th>ID</th><td>{{ $animal->animal_id }}</td></tr>
                        <tr><th>Вид</th><td>{{ $animal->species->name }}</td></tr>
                        <tr><th>Класс</th><td>{{ $animal->species->class }}</td></tr>
                        <tr><th>Поставщик</th><td>{{ $animal->supplier->name }}</td></tr>
                        <tr><th>Пол</th><td>{{ $animal->sex }}</td></tr>
                        <tr><th>Дата рождения</th><td>{{ $animal->birth_date ?? '—' }}</td></tr>
                        <tr><th>Дата поступления</th><td>{{ $animal->arrival_date_formatted }}</td></tr>
                        <tr><th>Сертификат CITES</th><td>{{ $animal->cites_certificate ?? '—' }}</td></tr>
                        <tr>
                            <th>Статус</th>
                            <td>
                                @php
                                    $badges = [
                                        'карантин'   => 'warning',
                                        'на продажу' => 'success',
                                        'продано'    => 'secondary',
                                        'списано'    => 'dark',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $badges[$animal->status] ?? 'light' }}">
                                    {{ $animal->status }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- цены и действия --}}
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header fw-bold">Цены и действия</div>
                <div class="card-body">
                    <table class="table table-sm mb-3">
                        <tr><th>Закупочная цена</th><td>{{ number_format($animal->purchase_price, 2) }} ₽</td></tr>
                        <tr><th>Цена продажи</th><td>{{ number_format($animal->sale_price, 2) }} ₽</td></tr>
                        @if($animal->sale)
                            <tr><th>Продано за</th><td>{{ number_format($animal->sale->total_price, 2) }} ₽</td></tr>
                            <tr><th>Покупатель</th><td>{{ $animal->sale->client->full_name }}</td></tr>
                            <tr><th>Дата продажи</th><td>{{ $animal->sale->sale_date }}</td></tr>
                        @endif
                    </table>

                    {{-- кнопка перевода из карантина --}}
                    @if($animal->status === 'карантин')
                        <form method="POST" action="{{ route('animals.approve', $animal) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-success w-100 mb-2">
                                ✓ Перевести на продажу
                            </button>
                        </form>
                    @endif

                    {{-- удаление --}}
                    @if($animal->status !== 'продано')
                        <form method="POST" action="{{ route('animals.destroy', $animal) }}"
                              onsubmit="return confirm('Удалить это животное?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-outline-danger w-100">Удалить</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        {{-- ветеринарные записи --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header fw-bold">Ветеринарные записи</div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Дата</th><th>Тип</th><th>Диагноз</th><th>Лечение</th><th>Результат</th><th>Ветеринар</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($animal->vetRecords as $rec)
                            <tr>
                                <td>{{ $rec->record_date }}</td>
                                <td>{{ $rec->record_type }}</td>
                                <td>{{ $rec->diagnosis ?? '—' }}</td>
                                <td>{{ $rec->treatment ?? '—' }}</td>
                                <td>{{ $rec->result ?? '—' }}</td>
                                <td>{{ $rec->vet->full_name }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-2">Записей нет</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- журнал кормления --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header fw-bold">Журнал кормления</div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Дата</th><th>Корм</th><th>Количество</th><th>Сотрудник</th><th>Примечания</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($animal->feedingLog as $log)
                            <tr>
                                <td>{{ $log->feeding_date }}</td>
                                <td>{{ $log->feed->name }}</td>
                                <td>{{ $log->quantity }} {{ $log->feed->unit }}</td>
                                <td>{{ $log->employee->full_name }}</td>
                                <td>{{ $log->notes ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-2">Записей нет</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection