<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the locale from the query parameter, session, or default
        $locale = $request->get('lang') ?: Session::get('locale', config('app.locale'));
        
        // Debug logging
        \Log::info('Locale middleware triggered', [
            'requested_locale' => $request->get('lang'),
            'all_query_params' => $request->all(),
            'session_locale' => Session::get('locale'),
            'config_locale' => config('app.locale'),
            'final_locale' => $locale,
            'request_url' => $request->fullUrl()
        ]);
        
        // Validate the locale
        $supportedLocales = ['en', 'si', 'ta'];
        
        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
            \Log::info('Locale set successfully', ['locale' => $locale]);
        } else {
            // Fallback to default locale
            App::setLocale(config('app.locale'));
            \Log::info('Locale fallback used', ['locale' => config('app.locale')]);
        }
        
        return $next($request);
    }
}
