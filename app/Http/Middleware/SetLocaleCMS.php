<?php

namespace App\Http\Middleware;

use App\Enums\LanguageEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetLocaleCMS
{
    /**
     * @var string $locale
     */
    private $locale;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->locale = $request->get('locale') ?? $request->header('App-Locale');
        if (in_array($this->locale, LanguageEnum::asArray())) {
            Config::set('translatable.locale', $this->locale);
        } else {
            throw new NotFoundHttpException();
        }

        return $next($request);
    }
}
