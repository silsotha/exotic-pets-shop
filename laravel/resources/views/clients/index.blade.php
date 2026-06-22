@extends('layouts.app')

@section('title', 'Клиенты')
@section('page-title', 'Клиенты')

@section('content')
    <section class="admin-section">
        <header class="admin-section-header">
            <div class="admin-section-heading">
                <div class="admin-section-eyebrow">
                    <i class="bi bi-people"></i>
                    Покупатели
                </div>

                <h1 class="admin-section-title">Клиенты</h1>

                <p class="admin-section-description">
                    Контактные данные клиентов, сведения об аккаунтах и история совершённых покупок.
                </p>
            </div>

            <div class="admin-section-actions">
                <a
                    href="{{ route('clients.create') }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-person-plus"></i>
                    Добавить клиента
                </a>
            </div>
        </header>

        <div class="admin-panel">
            <div class="admin-panel-header">
                <div class="admin-panel-heading">
                    <h2 class="admin-panel-title">
                        База клиентов
                    </h2>

                    <p class="admin-panel-description">
                        Всего записей: {{ $clients->total() }}
                    </p>
                </div>
            </div>

            <div class="admin-table-scroll">
                <table class="admin-table admin-table-clients">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Клиент</th>
                            <th>Контакты</th>
                            <th>Аккаунт</th>
                            <th>Паспорт</th>
                            <th>Регистрация</th>
                            <th>Покупок</th>
                            <th class="admin-table-actions-cell">
                                Действия
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($clients as $client)
                            <tr>
                                <td class="admin-table-number">
                                    #{{ $client->client_id }}
                                </td>

                                <td>
                                    <div class="admin-table-primary">
                                        {{ $client->full_name }}
                                    </div>
                                </td>

                                <td>
                                    <div class="admin-contact-list">
                                        @if($client->phone)
                                            <a
                                                href="tel:{{ $client->phone }}"
                                                class="admin-contact-item"
                                            >
                                                <i class="bi bi-telephone"></i>
                                                <span>{{ $client->phone }}</span>
                                            </a>
                                        @endif

                                        @if($client->email)
                                            <a
                                                href="mailto:{{ $client->email }}"
                                                class="admin-contact-item"
                                            >
                                                <i class="bi bi-envelope"></i>
                                                <span>{{ $client->email }}</span>
                                            </a>
                                        @endif

                                        @if(!$client->phone && !$client->email)
                                            <span class="admin-table-secondary">
                                                Не указаны
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    @if($client->user_id)
                                        <span class="admin-status admin-status-sale">
                                            Аккаунт создан
                                        </span>
                                    @else
                                        <span class="admin-status admin-status-sold">
                                            Без аккаунта
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if($client->passport_data)
                                        <span
                                            class="admin-truncated-value"
                                            title="{{ $client->passport_data }}"
                                        >
                                            {{ \Illuminate\Support\Str::limit($client->passport_data, 24) }}
                                        </span>
                                    @else
                                        <span class="admin-table-secondary">
                                            Не указан
                                        </span>
                                    @endif
                                </td>

                                <td class="admin-table-number">
                                    {{ $client->registration_date }}
                                </td>

                                <td class="admin-table-number">
                                    <span class="admin-count-badge">
                                        {{ $client->sales_count ?? 0 }}
                                    </span>
                                </td>

                                <td class="admin-table-actions-cell">
                                    <div class="admin-table-actions">
                                        <a
                                            href="{{ route('clients.edit', $client) }}"
                                            class="admin-action-btn admin-action-edit"
                                            title="Редактировать клиента"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            <span>Изменить</span>
                                        </a>

                                        @if(auth()->user()->isAdmin() && $client->user_id)
                                            <form
                                                method="POST"
                                                action="{{ route('clients.reset-password', $client) }}"
                                                onsubmit="return confirm('Сбросить пароль клиента? Новый временный пароль будет показан один раз.')"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <button
                                                    type="submit"
                                                    class="admin-action-btn admin-action-password"
                                                    title="Сбросить пароль"
                                                >
                                                    <i class="bi bi-key"></i>
                                                    <span>Пароль</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="admin-empty-row">
                                <td colspan="8">
                                    <div class="admin-empty">
                                        <div class="admin-empty-icon">
                                            <i class="bi bi-people"></i>
                                        </div>

                                        <div class="admin-empty-title">
                                            Клиенты не добавлены
                                        </div>

                                        <div>
                                            Создай карточку клиента для оформления продажи.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($clients->hasPages())
                <footer class="admin-panel-footer">
                    {{ $clients->links() }}
                </footer>
            @endif
        </div>
    </section>
@endsection