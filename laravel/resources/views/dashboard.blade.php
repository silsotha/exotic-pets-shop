@extends('layouts.app')

@section('title', 'Обзор')
@section('page-title', 'Обзор системы')

@section('content')
    <section class="admin-section">
        <header class="admin-section-header">
            <div class="admin-section-heading">
                <div class="admin-section-eyebrow">
                    <i class="bi bi-bar-chart-line"></i>
                    Аналитика
                </div>

                <h1 class="admin-section-title">
                    Обзор системы
                </h1>

                <p class="admin-section-description">
                    Текущие показатели магазина, динамика продаж и записи, требующие внимания.
                </p>
            </div>

            @if(auth()->user()->isAdmin())
                <div class="admin-section-actions">
                    <a
                        href="{{ route('admin.dashboard.export') }}"
                        class="btn btn-secondary"
                    >
                        <i class="bi bi-download"></i>
                        Экспорт продаж
                    </a>
                </div>
            @endif
        </header>

        <div class="dashboard-metrics">
            <article class="dashboard-metric dashboard-metric-animals">
                <div class="dashboard-metric-top">
                    <div class="dashboard-metric-icon">
                        <i class="bi bi-grid"></i>
                    </div>

                    <span class="dashboard-metric-caption">
                        Каталог
                    </span>
                </div>

                <div class="dashboard-metric-value">
                    {{ $totalAnimals }}
                </div>

                <div class="dashboard-metric-label">
                    Всего животных
                </div>
            </article>

            <article class="dashboard-metric dashboard-metric-quarantine">
                <div class="dashboard-metric-top">
                    <div class="dashboard-metric-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>

                    <span class="dashboard-metric-caption">
                        Контроль
                    </span>
                </div>

                <div class="dashboard-metric-value">
                    {{ $onQuarantine }}
                </div>

                <div class="dashboard-metric-label">
                    На карантине
                </div>
            </article>

            <article class="dashboard-metric dashboard-metric-sale">
                <div class="dashboard-metric-top">
                    <div class="dashboard-metric-icon">
                        <i class="bi bi-shop"></i>
                    </div>

                    <span class="dashboard-metric-caption">
                        Доступно
                    </span>
                </div>

                <div class="dashboard-metric-value">
                    {{ $availableForSale }}
                </div>

                <div class="dashboard-metric-label">
                    На продажу
                </div>
            </article>

            <article class="dashboard-metric dashboard-metric-sold">
                <div class="dashboard-metric-top">
                    <div class="dashboard-metric-icon">
                        <i class="bi bi-bag-check"></i>
                    </div>

                    <span class="dashboard-metric-caption">
                        Продажи
                    </span>
                </div>

                <div class="dashboard-metric-value">
                    {{ $sold }}
                </div>

                <div class="dashboard-metric-label">
                    Продано животных
                </div>
            </article>

            <article class="dashboard-metric dashboard-metric-revenue-month">
                <div class="dashboard-metric-top">
                    <div class="dashboard-metric-icon">
                        <i class="bi bi-calendar3"></i>
                    </div>

                    <span class="dashboard-metric-caption">
                        Этот месяц
                    </span>
                </div>

                <div class="dashboard-metric-value dashboard-metric-value-money">
                    {{ number_format($revenueThisMonth, 0, ',', ' ') }} ₽
                </div>

                <div class="dashboard-metric-label">
                    Выручка за месяц
                </div>
            </article>

            <article class="dashboard-metric dashboard-metric-revenue-total">
                <div class="dashboard-metric-top">
                    <div class="dashboard-metric-icon">
                        <i class="bi bi-wallet2"></i>
                    </div>

                    <span class="dashboard-metric-caption">
                        Всё время
                    </span>
                </div>

                <div class="dashboard-metric-value dashboard-metric-value-money">
                    {{ number_format($revenueTotal, 0, ',', ' ') }} ₽
                </div>

                <div class="dashboard-metric-label">
                    Общая выручка
                </div>
            </article>
        </div>

        <div class="dashboard-chart-grid">
            <article class="admin-panel dashboard-chart-panel">
                <header class="admin-panel-header">
                    <div class="admin-panel-heading">
                        <h2 class="admin-panel-title">
                            Динамика продаж
                        </h2>

                        <p class="admin-panel-description">
                            Количество продаж и выручка за последние 6 месяцев.
                        </p>
                    </div>

                    <div class="dashboard-panel-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                </header>

                <div class="dashboard-chart-body">
                    <canvas id="salesChart"></canvas>
                </div>
            </article>

            <article class="admin-panel dashboard-chart-panel">
                <header class="admin-panel-header">
                    <div class="admin-panel-heading">
                        <h2 class="admin-panel-title">
                            Популярные виды
                        </h2>

                        <p class="admin-panel-description">
                            Топ-5 видов по количеству продаж.
                        </p>
                    </div>

                    <div class="dashboard-panel-icon">
                        <i class="bi bi-pie-chart"></i>
                    </div>
                </header>

                <div class="dashboard-chart-body dashboard-chart-body-small">
                    <canvas id="speciesChart"></canvas>
                </div>
            </article>
        </div>

        <div class="dashboard-lower-grid">
            <article class="admin-panel">
                <header class="admin-panel-header">
                    <div class="admin-panel-heading">
                        <h2 class="admin-panel-title">
                            Последние продажи
                        </h2>

                        <p class="admin-panel-description">
                            Недавно оформленные операции.
                        </p>
                    </div>

                    <a
                        href="{{ route('sales.index') }}"
                        class="admin-action-btn admin-action-view"
                    >
                        Все продажи
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </header>

                <div class="admin-table-scroll">
                    <table class="admin-table dashboard-table">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Животное</th>
                                <th>Клиент</th>
                                <th>Сумма</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($recentSales as $sale)
                                <tr>
                                    <td class="admin-table-number">
                                        {{ $sale->sale_date }}
                                    </td>

                                    <td>
                                        <div class="admin-table-primary">
                                            {{ $sale->animal->nickname ?? $sale->animal->species->name }}
                                        </div>

                                        @if($sale->animal->nickname)
                                            <div class="admin-table-secondary">
                                                {{ $sale->animal->species->name }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $sale->client->full_name }}
                                    </td>

                                    <td class="admin-table-number">
                                        <strong>
                                            {{ number_format($sale->total_price, 2, ',', ' ') }} ₽
                                        </strong>
                                    </td>
                                </tr>
                            @empty
                                <tr class="admin-empty-row">
                                    <td colspan="4">
                                        <div class="admin-empty dashboard-empty">
                                            <div class="admin-empty-icon">
                                                <i class="bi bi-receipt"></i>
                                            </div>

                                            <div class="admin-empty-title">
                                                Продаж пока нет
                                            </div>

                                            <div>
                                                Оформленные операции появятся в этом блоке.
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>

            <article class="admin-panel dashboard-attention-panel">
                <header class="admin-panel-header">
                    <div class="admin-panel-heading">
                        <div class="dashboard-attention-title">
                            <span class="dashboard-attention-icon">
                                <i class="bi bi-exclamation-lg"></i>
                            </span>

                            <h2 class="admin-panel-title">
                                Истёкший карантин
                            </h2>
                        </div>

                        <p class="admin-panel-description">
                            Требуют осмотра: {{ $overdueQuarantine->count() }}
                        </p>
                    </div>
                </header>

                <div class="admin-table-scroll">
                    <table class="admin-table dashboard-table">
                        <thead>
                            <tr>
                                <th>Животное</th>
                                <th>Поступило</th>
                                <th class="admin-table-actions-cell"></th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($overdueQuarantine as $animal)
                                <tr>
                                    <td>
                                        <div class="admin-table-primary">
                                            {{ $animal->nickname ?? $animal->species->name }}
                                        </div>

                                        @if($animal->nickname)
                                            <div class="admin-table-secondary">
                                                {{ $animal->species->name }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="admin-table-number">
                                        {{ $animal->arrival_date_formatted }}
                                    </td>

                                    <td class="admin-table-actions-cell">
                                        <a
                                            href="{{ route('animals.show', $animal) }}"
                                            class="admin-action-btn admin-action-attention"
                                        >
                                            <i class="bi bi-eye"></i>
                                            Открыть
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="admin-empty-row">
                                    <td colspan="3">
                                        <div class="admin-empty dashboard-empty">
                                            <div class="admin-empty-icon dashboard-empty-success">
                                                <i class="bi bi-check-lg"></i>
                                            </div>

                                            <div class="admin-empty-title">
                                                Просрочек нет
                                            </div>

                                            <div>
                                                Все сроки карантина находятся под контролем.
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </article>
        </div>
    </section>
@endsection

@push('scripts')
    <script id="dashboard-sales-data" type="application/json">
        {!! json_encode([
            'months' => $salesByMonth->pluck('month')->values(),
            'counts' => $salesByMonth->pluck('count')->values(),
            'revenue' => $salesByMonth->pluck('revenue')->values(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>

    <script id="dashboard-species-data" type="application/json">
        {!! json_encode([
            'names' => $topSpecies->pluck('name')->values(),
            'counts' => $topSpecies->pluck('total')->values(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/admin-dashboard.js') }}"></script>
@endpush