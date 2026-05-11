<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfIndexPhp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $fullUrl = $request->fullUrl();

        if ($request->isMethod('GET') && strpos($fullUrl, 'index.php') !== false) {
            $newUrl = str_replace('/index.php', '', $fullUrl);
            return redirect($newUrl.'/',301);
        }

        return $next($request);
    }
}
