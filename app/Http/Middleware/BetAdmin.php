<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BetAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->exists('BetAdmin')):
            $request->session()->flush();
            $request->session()->regenerate();
            session_start();
            session_destroy();
            return redirect(route('adminLogin'))->with('error','Please login to continue');
        endif;
        return $next($request);
    }
}
