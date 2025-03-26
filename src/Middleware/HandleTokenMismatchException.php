<?php

namespace Laravel419Handler\Middleware;

use Closure;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Log;

class HandleTokenMismatchException
{
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (TokenMismatchException $e) {
            if ($request->expectsJson()) {
                return response()->json(config('laravel419.json_response'), 419);
            }

            session()->flash('error', config('laravel419.flash_message'));

            // Decide where to redirect
            $redirectTo = url(config('laravel419.redirect_on_web', '/'));
            $backUrl = url()->previous();

            if ($backUrl && $backUrl !== $request->fullUrl()) {
                return redirect($backUrl)->with('refresh', config('laravel419.auto_refresh_on_back'));
            }

            return redirect($redirectTo);
        }
    }
}