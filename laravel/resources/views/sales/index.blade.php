@extends('layouts.app')

@section('title', 'Продажи')
@section('page-title', 'Продажи')

@section('content')
    <section class="admin-section">
        <header class="admin-section-header">
            <div class="admin-section-heading">
                <div class="admin-section-eyebrow">
                    <i class="bi bi-bag-check"></i>
                    Торговля
                </div>

                <h1 class="admin-section-title">Продажи</h1>

                <p class="admin-section-description">
                    Оформленные продажи животных, покупатели, продавцы, способы оплаты и договоры.
                </p>
            </div>

            <div class="admin-section-actions">
                <a
                    href="{{ route('sales.create') }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-plus-lg"></i>
                    Оформить продажу
                </a>
            </div>
        </header>

        <div class="admin-summary-grid">
            <article class="admin-summary-card">
                <div class="admin-summary-icon">
                    <i class="bi bi-receipt"></i>
                </div>

                <div>
                    <div class="admin-summary-label">
                        Продаж найдено
                    </div>

                    <div class="admin-summary-value">
                        {{ $sales->total() }}
                    </div>
                </div>
            </article>

            <article class="admin-summary-card">
                <div class="admin-summary-icon">
                    <i class="bi bi-wallet2"></i>
                </div>

                <div>
                    <div class="admin-summary-label">
                        Сумма за период
                    </div>

                    <div class="admin-summary-value">
                        {{ number_format($total, 2, ',', ' ') }} ₽
                    </div>
                </div>
            </article>
        </div>

        <div class="admin-panel">
            <div class="admin-panel-header">
                <div class="admin-panel-heading">
                    <h2 class="admin-panel-title">
                        Журнал продаж
                    </h2>

                    <p class="admin-panel-description">
                        Для отбора записей укажи период или способ оплаты.
                    </p>
                </div>
            </div>

            <form
                method="GET"
                action="{{ route('sales.index') }}"
                class="admin-filters"
            >
                <div class="admin-filter">
                    <label for="date_from" class="form-label">
                        Дата от
                    </label>

                    <input
                        id="date_from"
                        type="date"
                        name="date_from"
                        class="form-control"
                        value="{{ request('date_from') }}"
                    >
                </div>

                <div class="admin-filter">
                    <label for="date_to" class="form-label">
                        Дата до
                    </label>

                    <input
                        id="date_to"
                        type="date"
                        name="date_to"
                        class="form-control"
                        value="{{ request('date_to') }}"
                    >
                </div>

                <div class="admin-filter">
                    <label for="payment_method" class="form-label">
                        Способ оплаты
                    </label>

                    <select
                        id="payment_method"
                        name="payment_method"
                        class="form-select"
                    >
                        <option value="">
                            Все способы
                        </option>

                        @foreach(['наличные', 'карта', 'перевод'] as $method)
                            <option
                                value="{{ $method }}"
                                @selected(request('payment_method') === $method)
                            >
                                {{ ucfirst($method) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="admin-filter-actions">
                    <button
                        type="submit"
                        class="btn btn-secondary"
                    >
                        <i class="bi bi-funnel"></i>
                        Применить
                    </button>

                    <a
                        href="{{ route('sales.index') }}"
                        class="btn btn-light"
                    >
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
                            <th>Дата</th>
                            <th>Животное</th>
                            <th>Покупатель</th>
                            <th>Продавец</th>
                            <th>Сумма</th>
                            <th>Оплата</th>
                            <th>Договор</th>
                            <th class="admin-table-actions-cell">
                                Действия
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($sales as $sale)
                            @php
                                $paymentClasses = [
                                    'наличные' => 'admin-payment-cash',
                                    'карта' => 'admin-payment-card',
                                    'перевод' => 'admin-payment-transfer',
                                ];
                            @endphp

                            <tr>
                                <td class="admin-table-number">
                                    #{{ $sale->sale_id }}
                                </td>

                                <td class="admin-table-number">
                                    {{ $sale->sale_date }}
                                </td>

                                <td>
                                    <a
                                        href="{{ route('animals.show', $sale->animal_id) }}"
                                        class="admin-entity-link"
                                    >
                                        <span class="admin-table-primary">
                                            {{ $sale->animal->nickname ?? $sale->animal->species->name }}
                                        </span>

                                        <span class="admin-table-secondary">
                                            {{ $sale->animal->species->name }}
                                        </span>
                                    </a>
                                </td>

                                <td>
                                    {{ $sale->client->full_name }}
                                </td>

                                <td>
                                    {{ $sale->employee->full_name }}
                                </td>

                                <td class="admin-table-number">
                                    <strong>
                                        {{ number_format($sale->total_price, 2, ',', ' ') }} ₽
                                    </strong>
                                </td>

                                <td>
                                    <span class="admin-payment {{ $paymentClasses[$sale->payment_method] ?? 'admin-payment-default' }}">
                                        {{ ucfirst($sale->payment_method) }}
                                    </span>
                                </td>

                                <td>
                                    @if($sale->contract_number)
                                        <span class="admin-contract-number">
                                            {{ $sale->contract_number }}
                                        </span>
                                    @else
                                        <span class="admin-table-secondary">
                                            Не указан
                                        </span>
                                    @endif
                                </td>

                                <td class="admin-table-actions-cell">
                                    <div class="admin-table-actions">
                                        <a
                                            href="{{ route('sales.show', $sale) }}"
                                            class="admin-action-btn admin-action-view"
                                            title="Открыть продажу"
                                        >
                                            <i class="bi bi-eye"></i>
                                            <span>Просмотр</span>
                                        </a>

                                        @if(auth()->user()->isAdmin())
                                            <form
                                                method="POST"
                                                action="{{ route('sales.destroy', $sale) }}"
                                                onsubmit="return confirm('Отменить продажу?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="admin-action-btn admin-action-delete"
                                                    title="Отменить продажу"
                                                >
                                                    <i class="bi bi-x-lg"></i>
                                                    <span>Отменить</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="admin-empty-row">
                                <td colspan="9">
                                    <div class="admin-empty">
                                        <div class="admin-empty-icon">
                                            <i class="bi bi-bag-check"></i>
                                        </div>

                                        <div class="admin-empty-title">
                                            Продажи не найдены
                                        </div>

                                        <div>
                                            Измени параметры фильтра или оформи новую продажу.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sales->hasPages())
                <footer class="admin-panel-footer">
                    {{ $sales->withQueryString()->links() }}
                </footer>
            @endif
        </div>
    </section>
@endsection