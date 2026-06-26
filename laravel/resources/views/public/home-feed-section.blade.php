{{-- полностью самостоятельный блок после div новых поступлений --}}

@if($featuredFeeds->isNotEmpty())
    <div class="public-feed-section">
        <div class="pub-section">
            <div class="public-feed-section-heading">
                <div>
                    <div class="section-label">Рацион и уход</div>
                    <div class="section-title">Кормовые объекты</div>

                    <p class="public-feed-section-description">
                        Живые, замороженные и другие корма для животных,
                        представленных в магазине.
                    </p>
                </div>
            </div>

            <div class="feeds-grid">
                @foreach($featuredFeeds as $feed)
                    @include('public._feed-card', ['feed' => $feed])
                @endforeach
            </div>

            <div style="text-align:center; margin-top: 36px">
                <a href="{{ route('feeds') }}" class="btn-primary">Смотреть все корма</a>
            </div>
        </div>
    </div>
@endif
