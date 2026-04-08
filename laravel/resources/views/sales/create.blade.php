@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 700px">
    <h2 class="mb-4">Оформить продажу</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('sales.store') }}">
        @csrf

        {{-- животное --}}
        <div class="mb-3">
            <label class="form-label">Животное *</label>
            <select name="animal_id" class="form-select @error('animal_id') is-invalid @enderror"
                    required onchange="fillPrice(this)">
                <option value="">— выберите —</option>
                @foreach($animals as $a)
                    <option value="{{ $a->animal_id }}"
                            data-price="{{ $a->sale_price }}"
                            {{ old('animal_id') == $a->animal_id ? 'selected' : '' }}>
                        #{{ $a->animal_id }} — {{ $a->species->name }}
                        {{ $a->nickname ? '('.$a->nickname.')' : '' }}
                        — {{ number_format($a->sale_price, 2) }} ₽
                    </option>
                @endforeach
            </select>
            @error('animal_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- клиент --}}
        <div class="mb-3">
            <label class="form-label">Покупатель *</label>
            <div class="input-group">
                <select name="client_id" class="form-select @error('client_id') is-invalid @enderror" required>
                    <option value="">— выберите или создайте —</option>
                    @foreach($clients as $c)
                        <option value="{{ $c->client_id }}" {{ old('client_id') == $c->client_id ? 'selected' : '' }}>
                            {{ $c->full_name }} — {{ $c->phone }}
                        </option>
                    @endforeach
                </select>
                <a href="{{ route('clients.create') }}?back=sale" class="btn btn-outline-secondary">
                    + Новый
                </a>
            </div>
            @error('client_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- продавец --}}
        <div class="mb-3">
            <label class="form-label">Продавец *</label>
            <select name="employee_id" class="form-select @error('employee_id') is-invalid @enderror" required>
                <option value="">— выберите —</option>
                @foreach($employees as $e)
                    <option value="{{ $e->employee_id }}" {{ old('employee_id') == $e->employee_id ? 'selected' : '' }}>
                        {{ $e->full_name }}
                    </option>
                @endforeach
            </select>
            @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Дата продажи *</label>
                <input type="date" name="sale_date" class="form-control"
                    value="{{ old('sale_date', date('Y-m-d')) }}" required>
            </div>
            <div class="col mb-3">
                <label class="form-label">Итоговая сумма (₽) *</label>
                <input type="number" name="total_price" id="total_price" step="0.01"
                    class="form-control @error('total_price') is-invalid @enderror"
                    value="{{ old('total_price') }}" required>
                @error('total_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Способ оплаты *</label>
                <select name="payment_method" class="form-select" required>
                    <option value="">— выберите —</option>
                    @foreach(['наличные', 'карта', 'перевод'] as $m)
                        <option value="{{ $m }}" {{ old('payment_method') == $m ? 'selected' : '' }}>
                            {{ ucfirst($m) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col mb-3">
                <label class="form-label">Номер договора</label>
                <input type="text" name="contract_number" class="form-control"
                    value="{{ old('contract_number') }}" placeholder="ДКП-2026-001">
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success btn-lg">Оформить продажу</button>
            <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </div>
    </form>
</div>

<script>
// Автоподстановка цены при выборе животного
function fillPrice(select) {
    const price = select.options[select.selectedIndex].dataset.price;
    if (price) document.getElementById('total_price').value = price;
}
</script>
@endsection