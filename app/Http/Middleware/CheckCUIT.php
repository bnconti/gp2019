<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Modelos\Persona as Persona;
use App\Modelos\Usuario as Usuario;

class CheckCUIT
{
    protected $except_urls = [
        'usuarios.edit',
    ];

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
        

        if ($user) {
            $idUsuario = $user->id;
            $userDB = Usuario::find($idUsuario);
            $per = Persona::buscarPorIdUsuario($idUsuario);
            if ($per->cuit_cuil === "-") {
                return redirect('usuarios/'.$idUsuario.'/edit')->withErrors(['Por favor, complete su CUIT/CUIL/PAS para seguir navegando.']);
            } elseif (!($userDB->password)) {
                return redirect('usuarios/'.$idUsuario.'/edit')->withErrors(['Por favor, cree una contraseña para seguir navegando.']);
            }
        }

        return $next($request);
    }
}
