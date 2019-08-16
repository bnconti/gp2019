<?php

namespace App\Http\Middleware;

use Closure;
use App\Modelos\Persona as Persona;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CheckIdUsuario
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

        if (!($user->es_admin) && $user->id !== $request->route('usuario')->id) {
            return redirect('usuarios/' . $user->id . '/edit');
        }

        return $next($request);
    }
}
