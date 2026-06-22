@extends('layouts.public')

@section('title', 'Как выбрать животное')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/choose.css') }}"
    >
@endpush

@section('content')
<section class="choose-page">
    <div class="choose-hero">
        <span class="choose-kicker">Рекомендации перед покупкой</span>
        <h1>Как выбрать экзотическое животное</h1>
        <p>
            Перед покупкой важно учитывать не только внешний вид животного,
            но и сложность ухода, условия содержания, температуру, влажность,
            питание и уровень опыта владельца.
        </p>
    </div>

    <div class="choose-grid">
        <article class="choose-card">
            <div class="choose-number">01</div>
            <h2>Оцените свой опыт</h2>
            <p>
                Новичкам лучше выбирать виды с простыми условиями содержания,
                которые спокойнее переносят небольшие ошибки в уходе.
            </p>
        </article>

        <article class="choose-card">
            <div class="choose-number">02</div>
            <h2>Проверьте условия содержания</h2>
            <p>
                У каждого вида есть требования к температуре, влажности,
                укрытиям и размеру террариума.
            </p>
        </article>

        <article class="choose-card">
            <div class="choose-number">03</div>
            <h2>Уточните питание</h2>
            <p>
                Некоторые животные питаются насекомыми, другие требуют
                специальных кормов или строгого режима кормления.
            </p>
        </article>

        <article class="choose-card">
            <div class="choose-number">04</div>
            <h2>Не выбирайте только по внешности</h2>
            <p>
                Яркий или необычный вид может оказаться сложным в содержании.
                Лучше заранее оценить требования к уходу.
            </p>
        </article>

        <article class="choose-card">
            <div class="choose-number">05</div>
            <h2>Смотрите на уровень сложности</h2>
            <p>
                В каталоге указана сложность содержания: для новичков,
                средний уровень или для опытных владельцев.
            </p>
        </article>
    </div>

    <div class="choose-action">
        <a href="{{ route('catalog') }}" class="btn-primary">
            Перейти в каталог
        </a>
    </div>
</section>
@endsection