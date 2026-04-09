@extends('layouts.public')
@section('title', 'О нас')

@section('content')

{{-- заголовок --}}
<div class="pub-hero" style="min-height: 280px; padding: 48px">
    <div class="hero-content">
        <div class="hero-badge">🌿 О магазине</div>
        <h1 class="hero-title" style="font-size: 40px">
            ExoticPets — <em>с заботой</em><br>о редких питомцах
        </h1>
        <p class="hero-sub">
            Специализированный магазин экзотических животных
            с полной ветеринарной документацией и поддержкой после покупки.
        </p>
    </div>
</div>

{{-- о нас --}}
<div class="pub-section">
    <div class="section-label">О магазине</div>
    <div class="section-title">Кто мы такие</div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: start">
        <div>
            <p style="color: var(--smoke); line-height: 1.8; margin-bottom: 16px; font-size: 15px">
                ExoticPets — магазин экзотических животных, основанный людьми, которые искренне
                увлечены миром редких существ. Мы работаем с проверенными поставщиками,
                имеющими все необходимые лицензии и сертификаты CITES.
            </p>
            <p style="color: var(--smoke); line-height: 1.8; margin-bottom: 16px; font-size: 15px">
                Каждое животное проходит обязательный ветеринарный карантин перед поступлением
                в продажу. Наши ветеринары следят за здоровьем и условиями содержания питомцев
                на протяжении всего времени их пребывания в магазине.
            </p>
            <p style="color: var(--smoke); line-height: 1.8; font-size: 15px">
                Мы консультируем каждого покупателя об условиях содержания, кормлении
                и особенностях ухода за выбранным животным. Покупка у нас — это не просто
                сделка, а начало долгих отношений.
            </p>
        </div>

        <div>
            {{-- преимущества --}}
            <div style="display: flex; flex-direction: column; gap: 16px">
                @php
                    $features = [
                        ['🔬', 'Ветеринарный контроль',   'Каждое животное осматривается при поступлении и проходит карантин согласно нормам.'],
                        ['📋', 'Полная документация',     'Сертификаты CITES, ветеринарные паспорта и договоры купли-продажи для всех животных.'],
                        ['🚚', 'Надёжные поставщики',     'Работаем только с лицензированными поставщиками из России и зарубежья.'],
                        ['💬', 'Консультации',            'Помогаем подобрать питомца и расскажем всё об условиях содержания.'],
                    ];
                @endphp
                @foreach($features as [$icon, $title, $desc])
                <div style="display: flex; gap: 16px; align-items: flex-start;
                            background: var(--cream); border-radius: 12px; padding: 18px;
                            border: 1.5px solid #e8e0d4">
                    <span style="font-size: 28px; flex-shrink: 0">{{ $icon }}</span>
                    <div>
                        <div style="font-weight: 600; color: var(--forest); margin-bottom: 4px">
                            {{ $title }}
                        </div>
                        <div style="font-size: 13px; color: var(--smoke); line-height: 1.6">
                            {{ $desc }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- контакты --}}
<div class="pub-section" style="background: var(--mist); padding-top: 52px; padding-bottom: 52px">
    <div class="section-label">Контакты</div>
    <div class="section-title">Как нас найти</div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px">

        {{-- контактная информация --}}
        <div style="display: flex; flex-direction: column; gap: 16px">

            @php
                $contacts = [
                    ['📍', 'Адрес',         'Москва, ул. Примерная, д. 1, ТЦ "Зоомир", 2 этаж'],
                    ['📞', 'Телефон',       '+7 (920) 000-00-00'],
                    ['✉',  'Email',         'info@exoticpets.ru'],
                    ['🕐', 'Режим работы',  'Пн–Пт: 10:00–20:00 / Сб–Вс: 10:00–18:00'],
                ];
            @endphp

            @foreach($contacts as [$icon, $label, $value])
            <div style="display: flex; gap: 16px; align-items: flex-start;
                        background: #fff; border-radius: 12px; padding: 20px;
                        border: 1px solid #e8e0d4">
                <span style="font-size: 24px; flex-shrink: 0">{{ $icon }}</span>
                <div>
                    <div style="font-size: 11px; font-weight: 700; letter-spacing: 1px;
                                text-transform: uppercase; color: var(--sage); margin-bottom: 4px">
                        {{ $label }}
                    </div>
                    <div style="color: var(--forest); font-weight: 500">{{ $value }}</div>
                </div>
            </div>
            @endforeach

            {{-- кнопка каталога --}}
            <div style="margin-top: 8px">
                <a href="{{ route('catalog') }}" class="btn-primary"
                   style="display: inline-block; text-decoration: none">
                    Перейти в каталог
                </a>
            </div>
        </div>

        {{-- карта-заглушка --}}
        <div style="background: #fff; border-radius: 12px; border: 1px solid #e8e0d4;
                    overflow: hidden; min-height: 380px; display: flex;
                    flex-direction: column">
            <div style="flex: 1; background: linear-gradient(135deg, var(--mist), #d4e8d4);
                        display: flex; align-items: center; justify-content: center;
                        flex-direction: column; gap: 12px; padding: 32px">
                <span style="font-size: 64px">🗺</span>
                <div style="font-family: 'Playfair Display', serif; font-size: 20px;
                            color: var(--forest); font-weight: 600">
                    Москва, ул. Примерная, 1
                </div>
                <div style="font-size: 13px; color: var(--smoke); text-align: center">
                    м. Примерная, 5 минут пешком<br>
                    Парковка у ТЦ бесплатная
                </div>
                <a href="https://yandex.ru/maps" target="_blank"
                   style="margin-top: 8px; padding: 10px 24px; background: var(--sage);
                          color: #fff; border-radius: 8px; text-decoration: none;
                          font-size: 13px; font-weight: 600">
                    Открыть в Яндекс Картах
                </a>
            </div>
        </div>
    </div>
</div>

@endsection