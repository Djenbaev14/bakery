<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GL_OR_SELLER_ADMIN
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Role::find(Auth::user()->role_id)->name == 'GL_ADMIN' || Role::find(Auth::user()->role_id)->name == 'SELLER_ADMIN' ) {
            return $next($request);
        }
        return back();
    }
}
