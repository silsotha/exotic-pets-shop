@extends('layouts.app')

@section('title', 'Добавить кормовой объект')
@section('page-title', 'Кормовые объекты')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/admin-feed-form.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('css/feed-groups-stock.css') }}"
    >
    <link
        rel="stylesheet"
        href="{{ asset('css/feed-select-all.css') }}"
    >
@endpush

@section('content')
    <div class="container py-4" style="max-width: 900px">
        <h2 class="mb-4">Добавить кормовой объект</h2>

        <form method="POST" action="{{ route('admin.feeds.store') }}">
            @csrf

            @include('feeds._form')
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/feed-target-selection.js') }}"></script>
@endpush
