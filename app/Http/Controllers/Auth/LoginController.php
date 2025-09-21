<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use http\Env\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function redirectTo() { // Lab06 Метод контроллера для входа
        if(Auth::user()->isAdmin()){
            return route('home');
        } else{
            return route('index');
        }
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest')->except('logout'); // Lab06 доступ для гостя ко всем маршрутам, кроме выхода
        $this->middleware('auth')->only('logout'); //Lab06 доступ для авторизованного пользователя только к маршруты для выхода
    }

}
