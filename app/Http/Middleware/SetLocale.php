<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response //lab04 Middleware для установки языка при запросе
    {
        // Берём язык из сессии, если нет — используем дефолтный
        $locale = session('locale', config('app.locale'));

        App::setLocale($locale);

        return $next($request);
    }
}
