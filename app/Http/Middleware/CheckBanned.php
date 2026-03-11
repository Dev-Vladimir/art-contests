<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isBanned()) {
            Auth::logout();
            
            return redirect()->route('login')
                ->withErrors(['email' => 'Ваш аккаунт заблокирован. Обратитесь к администратору.']);
        }

        return $next($request);
    }
}