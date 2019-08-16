<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CheckRole
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
        $user = Session::get('user');

        if (!($user)) {
            return redirect('/');
        } elseif (!($user->es_admin)) {
            return Redirect::back()
                ->withErrors(['No tiene los permisos suficientes como para ingresar a esa sección.']);
        }

        return $next($request);
    }
}
