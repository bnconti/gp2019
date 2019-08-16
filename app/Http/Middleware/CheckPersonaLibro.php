<?php

namespace App\Http\Middleware;

use Closure;
use App\Modelos\Persona as Persona;
use App\Modelos\Publicaciones\Libro as Libro;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CheckPersonaLibro
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

            $idLibro = $request->route('libro');
            $publicacion = Libro::where('id', $idLibro)->first()->publicacion;
            
            $esAutor = false;
            foreach ($publicacion->autores as $autor) {
                if ($autor->id === $idPersona) {
                    $esAutor = true;
                    break;
                }
            }

            if (!($esAutor)) {
                return redirect('publicaciones')->withErrors(['No puede acceder a este libro porque no es autor del mismo.']);
            }
        }
        return $next($request);
    }
}
