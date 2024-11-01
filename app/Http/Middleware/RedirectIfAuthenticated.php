<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // $guards = empty($guards) ? [null] : $guards;
        $guards1 = 'anggota';
        $guards2 = 'web';
        $guards3 = 'teacher';

        // foreach ($guards as $guard) {
            if (Auth::guard($guards1)->check()) {
                return redirect('/home');
            }
            if (Auth::guard($guards2)->check()) {
                return redirect('/dashboard');
            }
            if (Auth::guard($guards3)->check()) {
                return redirect('/dashboard');
            }
        // }
        return $next($request);
    }
}
