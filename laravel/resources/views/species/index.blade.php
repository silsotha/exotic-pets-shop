@extends('layouts.app')
@section('title', 'Виды животных')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Виды животных</h2>
            <a href="{{ route('species.create') }}" class="btn btn-primary">+ Добавить вид</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Название</th>
                    <th>Класс</th>
                    <th>Среда обитания</th>
                    <th>Температура (°C)</th>
                    <th>Влажность (%)</th>
                    <th>Карантин (дней)</th>
                    <th>Животных</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($species as $s)
                    <tr>
                        <td>{{ $s->name }}</td>
                        <td><span class="badge bg-secondary">{{ $s->class }}</span></td>
                        <td>{{ $s->habitat ?? '—' }}</td>
                        <td>
                            @if($s->temp_min || $s->temp_max)
                                {{ $s->temp_min }}° — {{ $s->temp_max }}°
                            @else —
                            @endif
                        </td>
                        <td>
                            @if($s->humidity_min || $s->humidity_max)
                                {{ $s->humidity_min }}% — {{ $s->humidity_max }}%
                            @else —
                            @endif
                        </td>
                        <td>{{ $s->quarantine_days }}</td>
                        <td>{{ $s->animals_count ?? 0 }}</td>
                        <td>
                            <a href="{{ route('species.edit', $s) }}" class="btn btn-sm btn-warning">
                                Изменить
                            </a>
                            <form method="POST" action="{{ route('species.destroy', $s) }}" class="d-inline"
                                onsubmit="return confirm('Удалить этот вид?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">Видов нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $species->links() }}
    </div>
@endsection