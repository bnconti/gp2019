<?php

namespace App\Http\Middleware;

use Closure;
use App\Modelos\Persona as Persona;
use App\Modelos\Publicaciones\TesisTesina as TesisTesina;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CheckPersonaTesis
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

        if (!($user->es_admin)) {
            $idUsuario = $user->id;
            $per = Persona::buscarPorIdUsuario($idUsuario);
            $idPersona = $per->id;

            $idTesis = $request->route('tesisTesina');
            $publicacion = TesisTesina::where('id', $idTesis)->first()->publicacion;
        
            $esDirectorTesis = $publicacion->director->id === $per->id;
            $publicacion->codirector === null ?
             $esCodirectorTesis = false : 
             $esCodirectorTesis = $publicacion->codirector->id === $per->id;
            
            $esAutorTesis = $publicacion->autores[0]->id === $per->id;

            if (!($esDirectorTesis || $esCodirectorTesis || $esAutorTesis)) {
                return redirect('publicaciones')->withErrors(['No puede acceder a esta tesis porque no está relacionado con la misma.']);
            }
        }
        return $next($request);
    }
}
