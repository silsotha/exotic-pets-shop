<section class="admin-panel mt-4">
    <div class="admin-panel-header">
        <div class="admin-panel-heading">
            <h2 class="admin-panel-title">Изменить остаток</h2>
            <p class="admin-panel-description">
                Сейчас: {{ number_format((int) $feed->quantity_in_stock, 0, ',', ' ') }} {{ $feed->unit }}
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.feeds.stock.store', $feed) }}" class="p-3">
        @csrf
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="operation_type" class="form-label">Операция</label>
                <select id="operation_type" name="operation_type" class="form-select" required>
                    @foreach(config('exotic.feed_operation_types') as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 mb-3">
                <label for="quantity" class="form-label">Количество</label>
                <input id="quantity" type="number" name="quantity" min="1" step="1" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="notes" class="form-label">Комментарий</label>
                <input id="notes" type="text" name="notes" maxlength="1000" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Обновить остаток</button>
    </form>
</section>
