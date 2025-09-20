@extends('layouts.master') <!-- Lab03 Наследование от вида с шапкой сайта -->
@section('title', __('messages.home')) <!-- Lab04 Вывод значение в зависимости от локализации  -->
@section('content')

    <h1>{{ __('messages.all_products') }}</h1>
    <form method="GET" action="{{route("index")}}">
        <div class="filters row">
            <div class="col-sm-6 col-md-3">
                <label for="price_from">{{ __('messages.price_from') }}
                    <input type="text" name="price_from" id="price_from" size="6" value="{{ request()->price_from}}">
                </label>
                <label for="price_to">{{ __('messages.price_to') }}
                    <input type="text" name="price_to" id="price_to" size="6"  value="{{ request()->price_to }}">
                </label>
            </div>
            <div class="col-sm-2 col-md-2">
                <label for="hit">
                    <input type="checkbox" name="hit" id="hit" @if(request()->has('hit')) checked @endif> {{ __('messages.hit') }}
                </label>
            </div>
            <div class="col-sm-2 col-md-2">
                <label for="new">
                    <input type="checkbox" name="new" id="new" @if(request()->has('new')) checked @endif> {{ __('messages.new') }}
                </label>
            </div>
            <div class="col-sm-2 col-md-2">
                <label for="recommend">
                    <input type="checkbox" name="recommend" id="recommend" @if(request()->has('recommend')) checked @endif> {{ __('messages.recommend') }}
                </label>
            </div>
            <div class="col-sm-6 col-md-3">
                <button type="submit" class="btn btn-primary">{{ __('messages.filter') }}</button> <!-- Lab05 Отправка get запроса на сервер с фильтрами по товарам -->
                <a href="{{ route("index") }}" class="btn btn-warning">{{ __('messages.reset') }}</a>
            </div>
        </div>
    </form>

        <div class="row">
            @foreach($products as $product) <!-- Lab02 Вывод списка товаров -->
                @include('layouts.card', compact('product'))
            @endforeach
        </div>
        {{ $products->links('pagination::bootstrap-4') }}
@endsection
