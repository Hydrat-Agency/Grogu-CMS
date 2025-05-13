<?php

namespace Hydrat\GroguCMS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Omaralalwi\LexiTranslate\Traits\HasLocale;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    use HasLocale;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $locale): Response
    {
        if (($locale = $this->setupLocaleForRequest($request, $locale)) instanceof RedirectResponse) {
            return $locale;
        }

        return $next($request);
    }

    protected function setupLocaleForRequest(Request $request): string|RedirectResponse
    {
        $savedLocale = session('locale') ?: cookie('locale');
        $locale = $this->getValidatedLocale($locale) ?: app()->getLocale();

        // Detect browser locale and redirect to the correct route if it's different from the current locale
        if (blank($savedLocale)) {
            if (($browserLocale = $this->detectBrowserLocale($request)) instanceof RedirectResponse) {
                return $browserLocale;
            }

            $locale = $browserLocale;
        }

        App::setLocale($locale);
        session(['locale' => $locale]);
        cookie()->queue(cookie('locale', $locale, 60 * 24 * 365, null, null, true, true, false, 'Lax'));

        return $locale;
    }

    protected function detectBrowserLocale(Request $request): string|RedirectResponse
    {
        $browserLocale = $this->getValidatedLocale(substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2));

        if ($browserLocale !== $locale) {
            $routeName = $request->route()->getName();

            if (Str::startsWith($routeName, $locale.'.')) {
                if (Route::has($routeName = Str::replaceFirst($locale, $browserLocale, $routeName))) {
                    session(['locale' => $browserLocale]);
                    cookie()->queue(cookie('locale', $browserLocale, 60 * 24 * 365, null, null, true, true, false, 'Lax'));

                    return redirect()->route($routeName);
                }
            }
        }

        return $browserLocale;
    }
}
