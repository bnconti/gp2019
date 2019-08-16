<?php

namespace App\Http\Controllers;

use App\Modelos\Usuario;
use App\Modelos\Persona;
use App\Modelos\Proyecto;
use App\Modelos\Publicaciones\Publicacion;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkRole', ['only' => ['index']]);
        $this->middleware('checkIdUsuario', ['only' => ['edit']]);
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $usuarioId = DB::table('usuarios')->insertGetId (
            [
                'mail_itt' => $request->email_itt,
                'gmail' => $request->email_alt,

                'password' => Hash::make($request->pass),
                
                'rol' => $request->rol,
                'cargo' => $request->cargo,
                'dedicacion' => $request->dedicacion,

                'aceptado' => 0,
                'es_admin' => 0,
            ]
        );

        DB::table('persona')->insert(
            [
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'cuit_cuil' => $request->cuit,
                'usuarios_id' => $usuarioId,
            ]
        );
       
        return redirect('/')->with('exito', 'Usuario creado con éxito. Ahora debe esperar a que un administrador habilite su cuenta.');
    }

    public function getUsuarios()
    {
        $usuarios = Usuario::query();
        return DataTables::of($usuarios)
            ->addColumn('nombrecompleto', function ($usuario) {
                return $usuario->persona->nombre . " " . $usuario->persona->apellido;
            })
            ->addColumn('switch', function ($usuario) {
                if ($usuario->aceptado == 1) {
                    return '<form action="cambiarEstado/' . $usuario->id . '" method="POST">
                                ' . csrf_field() . '
                                ' . method_field('PATCH') . '
                                <label class="switch">
                                    <input type="checkbox" onchange="this.form.submit()" checked>
                                    <span class="slider round"></span>
                                </label>
                            </form>';
                } else {
                    return '<form action="cambiarEstado/' . $usuario->id . '" method="POST">
                                ' . csrf_field() . '
                                ' . method_field('PATCH') . '
                                <label class="switch">
                                    <input type="checkbox" onchange="this.form.submit()">
                                    <span class="slider round"></span>
                                </label>
                            </form>';
                }
            })
            ->addColumn('editar', function ($usuario) {
                return '<a href="' . route('usuarios.edit', $usuario->id) . '" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></a>';
            })->rawColumns(['switch', 'editar'])
            ->make(true);
    }

    public function index()
    {
        return view('usuarios.index');
    }

    public function edit(Usuario $usuario)
    {
        $proyectosTodos = Proyecto::all();
        $publicaciones = Publicacion::all();
        $proyectosDelUsuario = $usuario->persona->proyectos()
            ->where(function ($query) {
                $query->where('inicio_participacion', '<', now())
                    ->orWhereNull('inicio_participacion');
            })
            ->where(function ($query) {
                $query->where('fin_participacion', '>', now())
                    ->orWhereNull('fin_participacion');
            })
            ->get();

        $publicacionesDelUsuario = $usuario->persona->publicaciones;

        return view('usuarios.edit')->with('usuario', $usuario)
            ->with('proyectosTodos', $proyectosTodos)
            ->with('publicaciones', $publicaciones)
            ->with('proyectosDelUsuario', $proyectosDelUsuario)
            ->with('publicacionesDelUsuario', $publicacionesDelUsuario);
    }

    public function update(Request $request, $id)
    {        
        $usuario = Usuario::find($id);
        $persona = $usuario->persona;
       
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->cuit_cuil = $request->cuit;
        $persona->save();

        $usuario->mail_itt = $request->email_itt;
        $usuario->rol = $request->rol;
        $usuario->dedicacion = $request->dedicacion;
        $usuario->cargo = $request->cargo;
        $usuario->save();

        return back()->with('exito', 'Sus datos fueron modificados exitosamente.');
    }

    public function cambiarEstado($id)
    {
        $usuario = Usuario::find($id);

        if ($usuario->aceptado == 1) {
            $usuario->aceptado = 0;
            $usuario->save();
            return redirect('/usuarios')->with('usuario_actualizado', 'Usuario deshabilitado con éxito.');
        } else {
            $usuario->aceptado = 1;
            $usuario->save();
            return redirect('/usuarios')->with('usuario_actualizado', 'Usuario habilitado con éxito.');
        }
    }

    public function cambiarContra(Request $req, $id)
    {
        $usuario = Usuario::find($id);

        if (!($usuario->password) | Hash::check($req->pass_vieja, $usuario->password)) {
            $usuario->password = Hash::make($req->pass_nueva);
            $usuario->save();
            return back()->with('exito', 'Su contraseña fue actualizada.');
        } else {
            return back()->withErrors('La contraseña actual ingresada es incorrecta.');
        }

        
    }

    public function agregarProyecto(Request $request, $id)
    {
        $persona = Persona::find($id);
        $persona->proyectos()->attach($request->proyectoId, ['inicio_participacion' => now()]);
        $persona->save();

        return redirect()->back();
    }

    public function removerProyecto($id, $proyecto)
    {
        $persona = Persona::find($id);

        $persona->proyectos()
            ->updateExistingPivot($proyecto, array('fin_participacion' => now()), false);

        return redirect()->back();
    }

    public function agregarPublicacion(Request $request, $id)
    {
        $persona = Persona::find($id);
        $persona->publicaciones()->attach($request->publicacionId, ['rol' => 'Autor']);
        $persona->save();

        return redirect()->back();
    }

    public function removerPublicacion($id, $publicacion)
    {
        $persona = Persona::find($id);
        $persona->publicaciones()->detach($publicacion);
        $persona->save();

        return redirect()->back();
    }

    public static function checkEmailUsado(Request $req)
    {
        if ($req->email_itt) {
            $encontrado = DB::table('usuarios')->where('mail_itt', '=', $req->email_itt)->get();
            if ($encontrado->isNotEmpty()) {
                return "false";
             } else {
                return "true";
             }
        }
    }

}
