<?php

namespace App\Http\Middleware;

use Closure;

class KasirPintar
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
        if(!auth()->guard('admin')->user()){
            if(!auth()->guard('staff')->user()){
                if(!auth()->guard('owner')->user()){
                    return redirect('/');
                }
                // return redirect('/');
            }
            // return redirect('/');
        }
        return $next($request);
    }
}
