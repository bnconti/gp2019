<?php

namespace App\Http\Middleware;

use Closure;
use App\Modelos\Persona as Persona;
use App\Modelos\Publicaciones\ParteLibro as ParteLibro;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CheckPersonaParteLibro
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

            $idParte = $request->route('parteLibro');
            $publicacion = ParteLibro::where('id', $idParte)->first()->publicacion;
            
            $esAutor = false;
            foreach ($publicacion->autores as $autor) {
                if ($autor->id === $idPersona) {
                    $esAutor = true;
                    break;
                }
            }

            if (!($esAutor)) {
                return redirect('publicaciones')->withErrors(['No puede acceder a esta parte de libro porque no es autor de la misma.']);
            }
        }
        return $next($request);
    }
}
