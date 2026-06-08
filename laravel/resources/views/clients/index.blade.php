@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Клиенты</h2>
        <a href="{{ route('clients.create') }}" class="btn btn-primary">+ Добавить клиента</a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
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
                <th>Аккаунт</th>
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
                <td>
                    @if($client->user_id)
                        <span class="badge bg-success">создан</span>
                    @else
                        <span class="badge bg-secondary">нет</span>
                    @endif
                </td>
                <td>{{ $client->passport_data ?? '—' }}</td>
                <td>{{ $client->registration_date }}</td>
                <td>{{ $client->sales_count ?? 0 }}</td>
                <td style="white-space: nowrap;">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning">
                            Редактировать
                        </a>

                        @if(auth()->user()->isAdmin() && $client->user_id)
                            <form method="POST"
                                action="{{ route('clients.reset-password', $client) }}"
                                class="d-inline m-0"
                                onsubmit="return confirm('Сбросить пароль клиента? Новый временный пароль будет показан один раз.')">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    Сбросить пароль
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center text-muted">Клиентов нет</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $clients->links() }}
</div>
@endsection