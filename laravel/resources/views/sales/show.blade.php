@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 900px">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Продажа #{{ $sale->sale_id }}</h2>
            <div class="text-muted">
                Дата оформления: {{ $sale->sale_date }}
            </div>
        </div>

        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">← Назад</a>
    </div>

    <div class="row">
        <div class="col-md-7 mb-3">
            <div class="card h-100">
                <div class="card-header fw-bold">Детали сделки</div>

                <div class="card-body">
                    <table class="table table-sm mb-0">
                        <tr>
                            <th width="35%">Сумма</th>
                            <td>
                                <strong>{{ number_format($sale->total_price, 2, ',', ' ') }} ₽</strong>
                            </td>
                        </tr>

                        <tr>
                            <th>Способ оплаты</th>
                            <td>{{ ucfirst($sale->payment_method) }}</td>
                        </tr>

                        <tr>
                            <th>Номер договора</th>
                            <td>{{ $sale->contract_number ?? '—' }}</td>
                        </tr>

                        <tr>
                            <th>Продавец</th>
                            <td>{{ $sale->employee->full_name ?? '—' }}</td>
                        </tr>

                        <tr>
                            <th>Статус животного</th>
                            <td>
                                <span class="badge bg-secondary">
                                    {{ $sale->animal->status ?? '—' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-3">
            <div class="card h-100">
                <div class="card-header fw-bold">Покупатель</div>

                <div class="card-body">
                    <h5 class="mb-3">{{ $sale->client->full_name }}</h5>

                    <div class="mb-2">
                        <span class="text-muted">Телефон:</span>
                        <strong>{{ $sale->client->phone ?? '—' }}</strong>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Email:</span>
                        <strong>{{ $sale->client->email ?? '—' }}</strong>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Паспорт:</span>
                        <strong>{{ $sale->client->passport_data ?? '—' }}</strong>
                    </div>

                    <div class="mb-2">
                        <span class="text-muted">Личный кабинет:</span>

                        @if($sale->client->user_id)
                            <span class="badge bg-success">аккаунт создан</span>
                        @else
                            <span class="badge bg-secondary">нет аккаунта</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header fw-bold">Животное</div>

        <div class="card-body">
            <table class="table table-sm mb-0">
                <tr>
                    <th width="25%">Карточка</th>
                    <td>
                        <a href="{{ route('animals.show', $sale->animal_id) }}">
                            #{{ $sale->animal_id }}
                        </a>
                    </td>
                </tr>

                <tr>
                    <th>Вид</th>
                    <td>{{ $sale->animal->species->name ?? '—' }}</td>
                </tr>

                <tr>
                    <th>Кличка</th>
                    <td>{{ $sale->animal->nickname ?? '—' }}</td>
                </tr>

                <tr>
                    <th>Пол</th>
                    <td>{{ $sale->animal->gender ?? '—' }}</td>
                </tr>

                <tr>
                    <th>Дата поступления</th>
                    <td>{{ $sale->animal->arrival_date ?? '—' }}</td>
                </tr>

                <tr>
                    <th>Цена в карточке</th>
                    <td>
                        {{ $sale->animal->sale_price ? number_format($sale->animal->sale_price, 2, ',', ' ') . ' ₽' : '—' }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="alert alert-info">
        Эта продажа связана с профилем клиента. После входа клиент увидит покупку в личном кабинете.
    </div>

    @if(auth()->user()->isAdmin())
        <form method="POST" action="{{ route('sales.destroy', $sale) }}"
              onsubmit="return confirm('Отменить эту продажу? Животное вернётся в каталог.')">
            @csrf
            @method('DELETE')

            <button class="btn btn-outline-danger">Отменить продажу</button>
        </form>
    @endif
</div>
@endsection