@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <h2 class="mb-4">Dashboard</h2>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard</h2>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('dashboard.export') }}" class="btn btn-outline-success">
                    ↓ Экспорт продаж CSV
                </a>
            @endif
        </div>

        {{-- виджеты-счётчики --}}
        <div class="row g-3 mb-4">
            <div class="col-sm-6 col-xl-2">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body">
                        <div class="fs-2 fw-bold">{{ $totalAnimals }}</div>
                        <div>Всего животных</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-2">
                <div class="card text-dark bg-warning h-100">
                    <div class="card-body">
                        <div class="fs-2 fw-bold">{{ $onQuarantine }}</div>
                        <div>На карантине</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-2">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <div class="fs-2 fw-bold">{{ $availableForSale }}</div>
                        <div>На продажу</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-2">
                <div class="card text-white bg-secondary h-100">
                    <div class="card-body">
                        <div class="fs-2 fw-bold">{{ $sold }}</div>
                        <div>Продано</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-2">
                <div class="card text-white bg-info h-100">
                    <div class="card-body">
                        <div class="fs-2 fw-bold">{{ number_format($revenueThisMonth, 0, '.', ' ') }} ₽</div>
                        <div>Выручка за месяц</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-2">
                <div class="card text-white bg-dark h-100">
                    <div class="card-body">
                        <div class="fs-2 fw-bold">{{ number_format($revenueTotal, 0, '.', ' ') }} ₽</div>
                        <div>Выручка всего</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">

            {{-- график продаж по месяцам --}}
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header fw-bold">Динамика продаж (последние 6 месяцев)</div>
                    <div class="card-body">
                        <canvas id="salesChart" height="100"></canvas>
                    </div>
                </div>
            </div>

            {{-- топ видов --}}
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header fw-bold">Топ-5 продаваемых видов</div>
                    <div class="card-body">
                        <canvas id="speciesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">

            {{-- последние продажи --}}
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header fw-bold">Последние продажи</div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
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
                                        <td>{{ $sale->sale_date }}</td>
                                        <td>{{ $sale->animal->species->name }}</td>
                                        <td>{{ $sale->client->full_name }}</td>
                                        <td>{{ number_format($sale->total_price, 2) }} ₽</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-2">Продаж пока нет</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-primary">
                            Все продажи →
                        </a>
                    </div>
                </div>
            </div>

            {{-- карантин с просрочкой --}}
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header fw-bold text-danger">
                        ⚠ Карантин истёк ({{ $overdueQuarantine->count() }})
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-sm mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Животное</th>
                                    <th>Поступило</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($overdueQuarantine as $animal)
                                    <tr>
                                        <td>{{ $animal->species->name }}
                                            {{ $animal->nickname ? '(' . $animal->nickname . ')' : '' }}
                                        </td>
                                        <td>{{ $animal->arrival_date }}</td>
                                        <td>
                                            <a href="{{ route('animals.show', $animal) }}"
                                                class="btn btn-sm btn-outline-warning">
                                                Открыть
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-2">
                                            Просрочек нет ✓
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // данные из Laravel → JS
        const salesMonths = @json($salesByMonth->pluck('month'));
        const salesCounts = @json($salesByMonth->pluck('count'));
        const salesRevenue = @json($salesByMonth->pluck('revenue'));

        const speciesNames = @json($topSpecies->pluck('name'));
        const speciesCounts = @json($topSpecies->pluck('total'));

        // график продаж
        new Chart(document.getElementById('salesChart'), {
            type: 'bar',
            data: {
                labels: salesMonths,
                datasets: [
                    {
                        label: 'Количество продаж',
                        data: salesCounts,
                        backgroundColor: 'rgba(13, 110, 253, 0.6)',
                        yAxisID: 'y',
                    },
                    {
                        label: 'Выручка (₽)',
                        data: salesRevenue,
                        type: 'line',
                        borderColor: 'rgba(25, 135, 84, 1)',
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        yAxisID: 'y1',
                        tension: 0.3,
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index' },
                scales: {
                    y: { type: 'linear', position: 'left', title: { display: true, text: 'Продажи' } },
                    y1: {
                        type: 'linear', position: 'right', title: { display: true, text: 'Выручка ₽' },
                        grid: { drawOnChartArea: false }
                    }
                }
            }
        });

        // круговая диаграмма видов
        new Chart(document.getElementById('speciesChart'), {
            type: 'doughnut',
            data: {
                labels: speciesNames,
                datasets: [{
                    data: speciesCounts,
                    backgroundColor: [
                        '#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0'
                    ],
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>
@endsection