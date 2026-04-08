@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 700px">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ветеринарная запись #{{ $vetRecord->record_id }}</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('vet.edit', $vetRecord->record_id) }}" class="btn btn-warning">Редактировать</a>
            <a href="{{ route('vet.index') }}" class="btn btn-outline-secondary">← Назад</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-sm mb-0">
                <tr><th width="35%">Животное</th>
                    <td>
                        <a href="{{ route('animals.show', $vetRecord->animal_id) }}">
                            {{ $vetRecord->animal->species->name }}
                            {{ $vetRecord->animal->nickname ? '('.$vetRecord->animal->nickname.')' : '' }}
                        </a>
                    </td>
                </tr>
                <tr><th>Ветеринар</th><td>{{ $vetRecord->vet->full_name }}</td></tr>
                <tr><th>Дата</th><td>{{ $vetRecord->record_date }}</td></tr>
                <tr><th>Тип</th><td>{{ ucfirst($vetRecord->record_type) }}</td></tr>
                <tr><th>Диагноз</th><td>{{ $vetRecord->diagnosis ?? '—' }}</td></tr>
                <tr><th>Лечение</th><td>{{ $vetRecord->treatment ?? '—' }}</td></tr>
                <tr>
                    <th>Результат</th>
                    <td>
                        @php
                            $badges = ['здоров' => 'success', 'на лечении' => 'warning', 'карантин' => 'danger'];
                        @endphp
                        <span class="badge bg-{{ $badges[$vetRecord->result] ?? 'secondary' }}">
                            {{ $vetRecord->result }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection