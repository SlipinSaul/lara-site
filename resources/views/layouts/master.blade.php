
<!doctype html> <!-- Lab03 HTML вёрстка шапки сайта -->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('messages.shop') }}: @yield('title')</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/starter.template.css') }}" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('index')}}">{{ __('messages.shop') }}</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li  @if(Route::currentRouteNamed('index')) class="active" @endif><a href="{{route('index')}}">{{ __('messages.all_products') }}</a></li>
                <li @if(Route::currentRouteNamed('categor*')) class="active" @endif>
                    <a href="{{route('categories')}}">{{ __('messages.categories') }}</a>
                </li>
                <li @if(Route::currentRouteNamed('basket')) class="active" @endif>
                    <a href="{{route('basket')}}">{{ __('messages.basket') }}</a>
                </li>
                <li>
                    <a href="{{ route('set-locale', ['locale' => 'ru']) }}">RU</a>
                </li>
                <li>
                    <a href="{{ route('set-locale', ['locale' => 'en']) }}">EN</a>
                </li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                @guest
                    <li><a href="{{ route('login') }}">{{ __('messages.login') }}</a></li>
                @endguest

                @auth
                    @if(Auth::user()->isAdmin())
                        <li><a href="{{ route('home') }}">{{ __('messages.admin_panel') }}</a></li>
                    @else
                        <li><a href="{{ route('person.orders.index') }}">{{ __('messages.my_orders') }}</a></li>
                    @endif

                    <li><a href="{{ route('get-logout') }}">{{ __('messages.logout') }}</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="starter-template">
        @if(session()->has('success'))
                <p class="alert alert-success">{{ session()->get('success') }}</p>
        @endif
        @if(session()->has('warning'))
                <p class="alert alert-warning">{{ session()->get('warning') }}</p>
        @endif
    @yield('content')
    </div>
</div>
</body>
</html>
