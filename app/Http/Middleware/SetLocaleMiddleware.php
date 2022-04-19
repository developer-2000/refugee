<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // метод laravel выборки префикса языка, префикс без /
        $lang_prefix = ltrim(request()->route()->getPrefix(), '/');

        if($lang_prefix){
            App::setLocale($lang_prefix);
        }
        else{
            App::setLocale(config("app.locale"));
        }

        return $next($request);
    }
}
