<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class checkToDoCount
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
        if(Auth::check())
        {
            /** @var \App\Models\user **/
            $user = Auth::user();
            $request->attributes->add(['count' =>  $user->count]);
        }
        else
        {
            $request->attributes->add(['count' =>  "auth-check-failed"]);
        }
        $request->attributes->add(['finally' =>  "#"]);
        return $next($request);
    }
}
