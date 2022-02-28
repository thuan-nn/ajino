<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AcceptLanguage
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
        $locale = $request->get('locale') ?? $request->header('App-Locale');
        $appLocale = is_null($locale) ? 'vi' : $locale;
        if (in_array($locale, ['en', 'vi'])) {
            app()->setLocale($appLocale);
        }

        return $next($request);
    }
}
