@extends('layouts.master')
@section('title', "Товар")
@section('content')

        <h1>{{$product->name}}</h1>
        <p>Цена: <b>{{$product->price}} руб.</b></p>
        <img src="{{ Storage::url($product->image) }}"  width="750" height="650">
        <p>{{$product->description}}</p>
        <form action="{{route('basket.add', $product)}}" method="POST">
            @csrf
            @if($product->isAvailable())
                <button type="submit" class="btn btn-primary"
                        role="button">Добавить в корзину</button>
            @else
                Не доступен
            @endif
        </form>

@endsection
