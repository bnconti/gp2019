<?php

namespace App\Http\Middleware;

use Closure;
use App\Modelos\Persona as Persona;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CheckAsociacion
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
        //$idPersona = Persona::buscarPorIdUsuario($idUsuario);
        //$idProyecto = $request->route('proyecto')->id;
        
        $user = Session::get('user');
        
        $idUsuario = $user->id;
        $per = Persona::buscarPorIdUsuario($idUsuario);
        $pro = $request->route('proyecto');

        if (!($user->es_admin)) {
            
            $esDirector = $pro->director->id === $per->id;
            $pro->codirector === null ? $esCodirector = false : $esCodirector = $pro->codirector->id === $per->id;

            if (!($esDirector || $esCodirector)) {
                return redirect('inicio2')->withErrors(['No puede acceder a este proyecto porque no es director ni codirector del mismo.']);
            }
        }
        return $next($request);
    }
}
