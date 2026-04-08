@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Клиенты</h2>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">+ Добавить клиента</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>ФИО</th>
                <th>Телефон</th>
                <th>Email</th>
                <th>Паспорт</th>
                <th>Дата регистрации</th>
                <th>Покупок</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clients as $client)
            <tr>
                <td>{{ $client->client_id }}</td>
                <td>{{ $client->full_name }}</td>
                <td>{{ $client->phone ?? '—' }}</td>
                <td>{{ $client->email ?? '—' }}</td>
                <td>{{ $client->passport_data ?? '—' }}</td>
                <td>{{ $client->registration_date }}</td>
                <td>{{ $client->sales_count ?? 0 }}</td>
                <td>
                    <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-warning">
                        Редактировать
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted">Клиентов нет</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $clients->links() }}
</div>
@endsection