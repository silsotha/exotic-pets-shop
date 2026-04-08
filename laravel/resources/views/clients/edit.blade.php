@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 600px">
    <h2 class="mb-4">Редактировать клиента</h2>

    <form method="POST" action="{{ route('clients.update', $client) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">ФИО *</label>
            <input type="text" name="full_name"
                class="form-control @error('full_name') is-invalid @enderror"
                value="{{ old('full_name', $client->full_name) }}"
                required>
            @error('full_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Телефон</label>
                <input type="text" name="phone"
                    class="form-control"
                    value="{{ old('phone', $client->phone) }}">
            </div>
            <div class="col mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $client->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Серия и номер паспорта</label>
            <input type="text" name="passport_data"
                class="form-control"
                value="{{ old('passport_data', $client->passport_data) }}">
        </div>

        {{-- история покупок --}}
        @if($client->sales && $client->sales->count() > 0)
        <div class="mb-4">
            <label class="form-label fw-bold">История покупок</label>
            <table class="table table-sm table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Дата</th>
                        <th>Животное</th>
                        <th>Сумма</th>
                        <th>Договор</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($client->sales as $sale)
                    <tr>
                        <td>{{ $sale->sale_date }}</td>
                        <td>{{ $sale->animal->species->name }}</td>
                        <td>{{ number_format($sale->total_price, 2) }} ₽</td>
                        <td>{{ $sale->contract_number ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Отмена</a>
        </div>
    </form>
</div>
@endsection