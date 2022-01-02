<?php

namespace App\Http\Middleware;

use App\Models\Todo;
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
    *  
     */
    public function handle(Request $request, Closure $next)
    {
        //to createTodo.vue page
        $to = "create";
        $permission = "ALLOW";
        $message = "";
        $redirect = "";
        
        /** @var \App\Models\user */
        $user =  Auth::user();
        
        // dd(Todo::get()->count());

        if(Auth::check())
        {
           $id = Auth::id();
           $_count = Todo::where('user_id',$id)->count();
            if($_count >= 10 && $user->user_type != "premium_user") {
                $to = "";
                $permission = "DENIED";
                $message = "Go premium for unlimited todos! free user only limited to 10 todos only";
                $redirect = "plan-package";
            }
        }

        $request->attributes->add(['to' =>  $to,'permission' =>  $permission,'message' => $message,'redirect' => $redirect]);
        return $next($request);
    }
}
