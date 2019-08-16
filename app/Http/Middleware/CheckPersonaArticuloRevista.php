<?php

namespace App\Http\Middleware;

use App\Modelos\Persona as Persona;
use App\Modelos\Publicaciones\ArticuloRevista as ArticuloRevista;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CheckPersonaArticuloRevista
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

            $idArticulo = $request->route('articuloRevistum');
            $publicacion = ArticuloRevista::where('id', $idArticulo)->first()->publicacion;

            $esAutor = false;
            foreach ($publicacion->autores as $autor) {
                if ($autor->id === $idPersona) {
                    $esAutor = true;
                    break;
                }
            }

            if (!($esAutor)) {
                return redirect('publicaciones')->withErrors(['No puede acceder a este artículo porque no es autor del mismo.']);
            }
        }
        return $next($request);
    }
}
