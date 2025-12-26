<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureProfileRegistered
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    function handle($request, Closure $next)
    {
        // ログインユーザーに紐づくプロフィールがない場合、登録画面へ飛ばす
        if (auth()->check() && !auth()->user()->profile) { // profileリレーションがある前提
            return redirect()->route('profile.create');
        }

        return $next($request);
    }
}
