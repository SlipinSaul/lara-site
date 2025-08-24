@extends('auth.layouts.master')

@isset($product)
    @section('title', 'Редактировать товар ' . $product->name)
@else
    @section('title', 'Создать товар')
@endisset

@section('content')
    <div class="col-md-12">
        @isset($product)
            <h1>Редактировать товар <b>{{ $product->name }}</b></h1>
        @else
            <h1>Добавить товар</h1>
        @endisset
        <form method="POST" enctype="multipart/form-data"
              @isset($product)
                  action="{{ route('products.update', $product) }}"
              @else
                  action="{{ route('products.store') }}"
            @endisset
        >
            <div>
                @isset($product)
                    @method('PUT')
                @endisset
                @csrf
                <div class="input-group row">
                    <label for="code" class="col-sm-2 col-form-label">Код: </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                               id="code"
                               value="@isset($product){{ $product->code }}@endisset">
                        @include('auth.layouts.error', ['fieldName' => 'code'])
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Название: </label>
                    <div class="col-sm-6">

                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                               id="name"
                               value="@isset($product){{ $product->name }}@endisset">
                        @include('auth.layouts.error', ['fieldName' => 'name'])
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="category_id" class="col-sm-2 col-form-label">Категория: </label>
                    <div class="col-sm-6">
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        @isset($product)
                                            @if($category->id==$product->category_id)
                                                selected
                                    @endif
                                    @endisset
                                >{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="description" class="col-sm-2 col-form-label">Описание: </label>
                    <div class="col-sm-6">

								<textarea name="description" id="description" cols="72"
                                          rows="7" class="form-control @error('description') is-invalid @enderror">@isset($product)
                                        {{ $product->description }}
                                    @endisset</textarea>
                        @include('auth.layouts.error', ['fieldName' => 'description'])
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="image" class="col-sm-2 col-form-label">Картинка: </label>
                    <div class="col-sm-10">
                        @isset($product->image)
                            <div class="mb-2">
                                <a href="{{ Storage::url($product->image) }}" target="_blank">
                                    {{ $product->name }}.{{ File::extension($product->image) }}
                                </a>
                            </div>
                        @endisset
                             <input type="file"  name="image" id="image" class="form-control-file @error('image') is-invalid @enderror">
                        @error('image')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="price" class="col-sm-2 col-form-label">Цена: </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control @error('price') is-invalid @enderror" name="price"
                               id="price"
                               value="@isset($product){{ $product->price }}@endisset">
                        @include('auth.layouts.error', ['fieldName' => 'price'])
                    </div>
                </div>
                <div class="input-group row">
                    <label for="count" class="col-sm-2 col-form-label">Кол-во: </label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control @error('count') is-invalid @enderror" name="count" id="count"
                               value="@isset($product){{ $product->count }}@endisset">
                        @include('auth.layouts.error', ['fieldName' => 'count'])
                    </div>
                </div>
                <br>
                @foreach([
                'hit'=> 'Хит',
                'new'=> 'Новинка',
                'recommend'=> 'Рекомендуемые'
                 ] as $field => $title)
                    <div class="input-group row">
                        <label for="code" class="col-sm-2 col-form-label">{{ $title }}: </label>
                        <div class="col-sm-6">
                            <input type="checkbox" class="form-control" name="{{ $field }}"
                                   id="{{ $field }}"
                                       @if(isset($product) && $product->$field===1)
                                           checked="checked"
                                       @endif>
                        </div>
                    </div>
                    <br>
                @endforeach
                <button class="btn btn-success">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
