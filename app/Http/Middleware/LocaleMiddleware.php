<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->segment(1) != config('app.locale')) {
            App::setLocale((string) $request->segment(1));
            Config::set('translatable.locale', (string) $request->segment(1));
        } else {
            App::setLocale((string) config('app.locale'));
            Config::set('translatable.locale', (string) config('app.locale'));
        }

        return $next($request);
    }
}
