@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 700px">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Продажа #{{ $sale->sale_id }}</h2>
        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">← Назад</a>
    </div>

    <div class="card mb-3">
        <div class="card-header fw-bold">Детали сделки</div>
        <div class="card-body">
            <table class="table table-sm mb-0">
                <tr><th width="35%">Животное</th>
                    <td>
                        <a href="{{ route('animals.show', $sale->animal_id) }}">
                            {{ $sale->animal->species->name }}
                            {{ $sale->animal->nickname ? '('.$sale->animal->nickname.')' : '' }}
                        </a>
                    </td>
                </tr>
                <tr><th>Покупатель</th><td>{{ $sale->client->full_name }}</td></tr>
                <tr><th>Телефон</th><td>{{ $sale->client->phone }}</td></tr>
                <tr><th>Паспорт</th><td>{{ $sale->client->passport_data ?? '—' }}</td></tr>
                <tr><th>Продавец</th><td>{{ $sale->employee->full_name }}</td></tr>
                <tr><th>Дата</th><td>{{ $sale->sale_date }}</td></tr>
                <tr><th>Сумма</th><td><strong>{{ number_format($sale->total_price, 2) }} ₽</strong></td></tr>
                <tr><th>Способ оплаты</th><td>{{ ucfirst($sale->payment_method) }}</td></tr>
                <tr><th>Номер договора</th><td>{{ $sale->contract_number ?? '—' }}</td></tr>
            </table>
        </div>
    </div>

    @if(auth()->user()->isAdmin())
        <form method="POST" action="{{ route('sales.destroy', $sale) }}"
              onsubmit="return confirm('Отменить эту продажу? Животное вернётся в каталог.')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger">Отменить продажу</button>
        </form>
    @endif
</div>
@endsection