<div class="col-sm-6 col-md-4"> <!-- Lab03 HTML вёрстка карточки товара  -->
    <div class="thumbnail">
        <div class="labels">
            @if($product->isNew())
                <span class="badge badge-success">{{ __('messages.new') }}</span><!-- Lab04 Вывод значение в зависимости от локализации  -->
            @endif

            @if($product->isRecommend())
                <span class="badge badge-warning">{{ __('messages.recommend') }}</span>
            @endif

            @if($product->isHit())
                <span class="badge badge-danger">{{ __('messages.hit') }}</span>
            @endif
        </div>
        <img src="{{ Storage::url($product->image) }}"  alt="{{ Storage::url('ProductImage.png') }}">
        <div class="caption">
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->price }} руб.</p>
            <p>
                <form action="{{route('basket.add', $product)}}" method="POST">
                @csrf
                @if($product->isAvailable())
                    <button type="submit" class="btn btn-primary"
                            role="button">{{ __('messages.basket_add') }}</button>
                @else
                    {{ __('messages.not_available') }}
                @endif
                <a href="{{ route('product', [isset($category) ? $category->code: $product->category->code, $product->code]) }}" class="btn btn-default"
                   role="button">{{ __('messages.more') }}</a>
                </form>
            </p>
        </div>
    </div>
</div>
