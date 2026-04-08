@extends('layouts.app')
@section('title', 'Поставщики')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Поставщики</h2>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">+ Добавить</a>
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
                    <th>Контакт</th>
                    <th>Телефон</th>
                    <th>Email</th>
                    <th>Лицензия</th>
                    <th>Животных</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $s)
                    <tr>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->contact_person ?? '—' }}</td>
                        <td>{{ $s->phone ?? '—' }}</td>
                        <td>{{ $s->email ?? '—' }}</td>
                        <td><code>{{ $s->license_number ?? '—' }}</code></td>
                        <td>{{ $s->animals_count }}</td>
                        <td>
                            <a href="{{ route('suppliers.edit', $s) }}" class="btn btn-sm btn-warning">
                                Изменить
                            </a>
                            <form method="POST" action="{{ route('suppliers.destroy', $s) }}" class="d-inline"
                                onsubmit="return confirm('Удалить поставщика?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Поставщиков нет</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $suppliers->links() }}
    </div>
@endsection