<?php

namespace App\Http\Middleware;

use App;
use Carbon\Carbon;
use Closure;

class LocaleMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if ($user = $request->user()) {
			App::setLocale($user->language);
		} else if ($request->session()->has('appLocale') && array_key_exists($request->session()->get('appLocale'), config('app.locales'))) {
			App::setLocale($request->session()->get('appLocale'));
		}
		
		if (App::getLocale() == '') { // This is optional as Laravel will automatically set the fallback language if there is none specified
			App::setLocale(config('app.fallback_locale'));
		}
		
		
		Carbon::setLocale(App::getLocale());
		
		return $next($request);
	}
}
