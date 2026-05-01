<?php

namespace Slimani\CookieConsent\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCookieConsent
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
