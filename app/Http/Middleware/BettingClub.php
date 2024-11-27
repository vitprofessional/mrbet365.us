<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BettingClub
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
        if (!$request->session()->exists('BettingClub')):
            return redirect(route('clubLogin'))->with('error','Please login to continue');
        endif;
        return $next($request);
    }
}
