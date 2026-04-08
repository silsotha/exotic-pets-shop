@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Продажи</h2>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">+ Оформить продажу</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- фильтры --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-2">
            <input type="date" name="date_from" class="form-control"
                value="{{ request('date_from') }}" placeholder="Дата от">
        </div>
        <div class="col-md-2">
            <input type="date" name="date_to" class="form-control"
                value="{{ request('date_to') }}" placeholder="Дата до">
        </div>
        <div class="col-md-2">
            <select name="payment_method" class="form-select">
                <option value="">Все способы</option>
                @foreach(['наличные', 'карта', 'перевод'] as $m)
                    <option value="{{ $m }}" {{ request('payment_method') == $m ? 'selected' : '' }}>
                        {{ ucfirst($m) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary w-100">Фильтр</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('sales.index') }}" class="btn btn-outline-danger w-100">Сбросить</a>
        </div>
    </form>

    {{-- итого --}}
    <div class="alert alert-info py-2">
        Итого за период: <strong>{{ number_format($total, 2) }} ₽</strong>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Дата</th>
                <th>Животное</th>
                <th>Покупатель</th>
                <th>Продавец</th>
                <th>Сумма</th>
                <th>Оплата</th>
                <th>Договор</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            <tr>
                <td>{{ $sale->sale_id }}</td>
                <td>{{ $sale->sale_date }}</td>
                <td>
                    <a href="{{ route('animals.show', $sale->animal_id) }}">
                        {{ $sale->animal->species->name }}
                        {{ $sale->animal->nickname ? '('.$sale->animal->nickname.')' : '' }}
                    </a>
                </td>
                <td>{{ $sale->client->full_name }}</td>
                <td>{{ $sale->employee->full_name }}</td>
                <td>{{ number_format($sale->total_price, 2) }} ₽</td>
                <td>{{ $sale->payment_method }}</td>
                <td>{{ $sale->contract_number ?? '—' }}</td>
                <td>
                    <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info">Просмотр</a>
                    @if(auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('sales.destroy', $sale) }}" class="d-inline"
                              onsubmit="return confirm('Отменить продажу?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Отменить</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center text-muted">Продаж не найдено</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $sales->withQueryString()->links() }}
</div>
@endsection