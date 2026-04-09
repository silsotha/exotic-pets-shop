@extends('layouts.app')
@section('title', 'Добавить клиента')

@section('content')
    <div class="container py-4" style="max-width: 600px">
        <h2 class="mb-4">Добавить клиента</h2>

        <form method="POST" action="{{ route('clients.store') }}" id="client-form">
            @csrf

            {{-- ФИО --}}
            <div class="mb-3">
                <label class="form-label">ФИО *</label>
                <input type="text" name="full_name" id="full_name"
                    class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}"
                    placeholder="Иванов Иван Иванович" minlength="3" maxlength="100" required>
                <div class="form-text">Только буквы, пробелы и дефисы (3–100 символов)</div>
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                {{-- телефон --}}
                <div class="col mb-3">
                    <label class="form-label">Телефон</label>
                    <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone') }}" placeholder="+7 (___) ___-__-__" maxlength="18">
                    <div class="form-text">Формат: +7 (999) 999-99-99</div>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- email --}}
                <div class="col mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="example@mail.ru">
                    <div id="email-feedback" class="invalid-feedback"></div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- паспорт --}}
            <div class="mb-4">
                <label class="form-label">Серия и номер паспорта</label>
                <input type="text" name="passport_data" id="passport_data"
                    class="form-control @error('passport_data') is-invalid @enderror" value="{{ old('passport_data') }}"
                    placeholder="4516 123456" maxlength="11">
                <div class="form-text">
                    Требуется для договора на животных с CITES. Формат: 4516 123456
                </div>
                @error('passport_data')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Отмена</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // маска телефона
        document.getElementById('phone').addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.startsWith('8')) val = '7' + val.slice(1);
            if (!val.startsWith('7')) val = '7' + val;
            val = val.slice(0, 11);

            let formatted = '';
            if (val.length >= 1) formatted = '+7';
            if (val.length >= 2) formatted += ' (' + val.slice(1, 4);
            if (val.length >= 5) formatted += ') ' + val.slice(4, 7);
            if (val.length >= 8) formatted += '-' + val.slice(7, 9);
            if (val.length >= 10) formatted += '-' + val.slice(9, 11);

            e.target.value = formatted;
        });

        // маска паспорта
        document.getElementById('passport_data').addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.length > 4) {
                e.target.value = val.slice(0, 4) + ' ' + val.slice(4, 10);
            } else {
                e.target.value = val;
            }
        });

        // клиентская валидация ФИО
        document.getElementById('full_name').addEventListener('blur', function () {
            const val = this.value.trim();
            const valid = /^[\u0400-\u04FF\u0041-\u007A\s\-]{3,100}$/i.test(val);
            this.classList.toggle('is-invalid', !valid && val.length > 0);
            this.classList.toggle('is-valid', valid);
        });

        // клиентская валидация email
        document.getElementById('email').addEventListener('blur', function () {
            const val = this.value.trim();
            if (!val) return; // необязательное поле
            const valid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
            this.classList.toggle('is-invalid', !valid);
            this.classList.toggle('is-valid', valid);
            if (!valid) {
                document.getElementById('email-feedback').textContent = 'Введите корректный адрес почты.';
            }
        });
    </script>
@endpush