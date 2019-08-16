<?php

namespace App\Http\Controllers;

use App\Modelos\Persona as Persona;
use App\Modelos\Proyecto as Proyecto;
use App\Modelos\Usuario;
use DB;
use Illuminate\Http\Request;
use User;
use Validator;
use Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\Session;

class ProyectoController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAsociacion', ['only' => ['edit']]);
    }

    /* Carga la página principal de los proyectos, o sea la que contiene la tabla con todos ellos */
    public function index()
    {
        return view('proyectos.index');
    }

    /* Carga la página principal del login */
    public function login()
    {
        return view('home.login');
    }

    /* logout del usuario */
    public function logout()
    {
        Session::flush();
        Session::save();
        return view('home.logout');
    }

    /* Redireccion para usuarios no aceptados */
    public function locked()
    {
        return view('home.locked');
    }

    public function editUser()
    {
        $usuario = Usuario::buscarPorId($_GET['userId']);
        $usuario->rol = $_GET['rol'];
        $usuario->mail_itt = $_GET['email'];
        $usuario->cargo = $_GET['cargo'];
        $usuario->dedicacion = $_GET['dedicacion'];
        $usuario->save();

        $persona = Persona::buscarPorIdUsuario($_GET['userId']);
        $persona->apellido = $_GET['apellido'];
        $persona->nombre = $_GET['nombre'];
        $persona->cuit_cuil = $_GET['dni'];
        $persona->save();

        Session::put('user', $usuario);
        Session::put('persona', $persona);
        Session::save();

        return redirect('/inicio2');
    }

    /* Genera una query de todos los proyectos y envía la DataTable al script Ajax */
    public function getProyectos(Request $request)
    {
        /*
        $esAdmin = $request->session()->get('user')->es_admin;

        if ($esAdmin) {
            $proyectos = DB::select('SELECT * from tablaproyectos');
        } else {
            $idUsuario = $request->session()->get('user')->id;
            $idPersona = Persona::buscarPorIdUsuario($idUsuario)->id;

            $proyectos = DB::select(DB::raw("SELECT * FROM tablaproyectos WHERE tablaproyectos.id IN (SELECT DISTINCT id FROM (SELECT proyectos.id as id, proyectos.director_id as director, proyectos.codirector_id as codirector, miembros.personas_id as miembro FROM proyectos INNER JOIN personas_proyectos as miembros ON proyectos.id = miembros.proyectos_id WHERE proyectos.director_id = '$idPersona' OR proyectos.codirector_id = '$idPersona' OR miembros.personas_id = '$idPersona') AS tablita)"));            
        }
        */

        $proyectos = DB::select('SELECT * from tablaproyectos');

        return DataTables::of($proyectos)
            ->addColumn('editar', function ($proyecto) {
                return '<a href="' . route('proyectos.edit', $proyecto->id) . '" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></a>';
            })
            ->rawColumns(['editar'])
            ->make(true);
    }

    /* Carga la vista para crear un nuevo proyecto */
    public function create()
    {
        return view('proyectos.create');
    }

    /* Me traigo los datos del formulario en request(),
    los valido y persisto el nuevo proyecto */
    public function store(Request $request)
    {
        /*  En reglasValidacion() (ver el final de este archivo) tengo definido los atributos que obligo sean enviados
        a la hora de crear un proyecto. mensajes() es solamente para traducir los mensajes de error. */
        $validator = Validator::make($request->all(), ProyectoController::reglasValidacion(), ProyectoController::mensajes());

        if ($validator->fails()) {
            /* Si falló al validar los atributos, vuelvo a la página con un msj. de error
            indicando los atributos faltantes o inválidos */
            return redirect('/proyectos/create')->withErrors($validator)->withInput();
        } else // Creo un Proyecto nuevo y le asigno los atributos a partir del request recibido
        {
            $proyecto = new Proyecto;

            $proyecto->titulo = $request->titulo;
            $proyecto->tipo_actividad = $request->tipo_actividad;
            $proyecto->expediente = $request->expediente;
            $proyecto->resolucion = $request->resolucion;
            $proyecto->tipo_proyecto = $request->tipo_proyecto;
            $proyecto->desde = $request->desde;
            $proyecto->hasta = $request->hasta;
            $proyecto->descripcion = $request->descripcion;

            /*  El director puede existir en la BD por lo no lo puedo asignar sin más.
            Tengo que comprobar si existe, en cuyo caso lo traigo, caso contrario se crea
            una Persona nueva con los datos */
            $director = Persona::buscar($request->cuit_director);
            if ($director == null) {
                /*  Si la búsqueda no encuentra nada, creo una Persona nueva
                con los datos suministrados y le asigno al Proyecto el nuevo ID como Director  */
                $proyecto->director_id = Persona::crear($request->nombre_director, $request->apellido_director, $request->cuit_director)->id;
            } else {
                // Y si existe le asigno el ID directamente
                $proyecto->director_id = $director->id;
            }

            // Lo mismo para el codirector, pero este es opcional.
            if ($request->cuit_codirector) {
                $codirector = Persona::buscar($request->cuit_codirector);
                if ($codirector == null) {
                    $proyecto->codirector_id = Persona::crear($request->nombre_codirector, $request->apellido_codirector, $request->cuit_codirector)->id;
                } else {
                    $proyecto->codirector_id = $codirector->id;
                }
            }

            /*  Ahora persisto el Proyecto y me lo traigo porque falta cargar las tablas de
            Entidades y Miembros (¿hay una forma mejor de hacer esto?).                 */
            $proyecto->save();
            $proyecto = Proyecto::all()->last();

            // Vuelvo a la lista de Proyectos con un msj. de éxito.
            return redirect('/proyectos')->with('exito', 'Proyecto guardado exitosamente.');
        }
    }

    /* Carga la vista para editar el proyecto, enviándole el seleccionado */
    public function edit(Proyecto $proyecto)
    {
        return view('proyectos.edit', compact('proyecto'));
    }

    /* Método para actualizar los datos de un proyecto */
    public function update(Request $request, $id)
    {
        // Antes de arrancar valido los datos que me pasaron
        $validator = Validator::make($request->all(), ProyectoController::reglasValidacion(), ProyectoController::mensajes());

        if ($validator->fails()) {
            // Con este redirect vuelvo a la página de edición
            return redirect('/proyectos/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        } else {
            // A partir del ID que nos pasaron busco el Proyecto.
            $proyecto = Proyecto::find($id);

            $proyecto->titulo = $request->titulo;
            $proyecto->tipo_actividad = $request->tipo_actividad;
            $proyecto->expediente = $request->expediente;
            $proyecto->resolucion = $request->resolucion;
            $proyecto->tipo_proyecto = $request->tipo_proyecto;
            $proyecto->desde = $request->desde;
            $proyecto->hasta = $request->hasta;
            $proyecto->descripcion = $request->descripcion;

            /*  Tres casos posibles a la hora de actualizar el director y codirector:
            creo uno nuevo, reasigno uno existente, o lo dejo como estaba (sin cambios). */

            $director = Persona::buscar($request->cuit_director);
            if ($director == null) { // Busco el director a partir de su CUIT; si no encuentro nada lo creo (es una Persona nueva)
                $proyecto->director_id = Persona::crear($request->apellido_director, $request->nombre_director, $request->cuit_director)->id;
            } else { // Si el director pasado es distinto al actual lo asigno
                if ($proyecto->director->id != $director->id) {
                    $proyecto->director_id = $director->id;
                }
                // Caso contrario queda igual que antes y no se hace nada
            }

            if ($request->cuit_codirector) { // Si me pasaron un CUIT de codirector arranco con esto
                $codirector = Persona::buscar($request->cuit_codirector);
                if ($codirector == null) { // Si no existe el codirector pasado creo uno
                    $codirector = Persona::crear($request->apellido_codirector, $request->nombre_codirector, $request->cuit_codirector);
                }
                if ($proyecto->codirector_id == null || $proyecto->codirector_id != $codirector->id) {
                    $proyecto->codirector_id = $codirector->id;
                }
            } else {
                // No se pasó ningún codirector. Si había uno asignado lo elimino.
                $proyecto->codirector_id = null;
            }

            $proyecto->save();
            return redirect('/proyectos')->with('exito', 'Proyecto modificado exitosamente.');
        }
    }

    public function reglasValidacion()
    {
        return [
            'titulo' => 'required|min:3|max:255',
            'desde' => 'required|date',
            'hasta' => 'required|date|after:desde',
            'descripcion' => 'required|min:3|max:255',
            'resolucion' => 'required',
            'expediente' => 'required',

            'apellido_director' => 'required',
            'nombre_director' => 'required',
            'cuit_director' => 'required',
        ];
    }

    public function mensajes()
    {
        return [
            'required' => 'El campo «:attribute» es requerido.',
            'min' => 'El campo «:attribute» debe tener un mínimo de :min caracteres.',
            'after' => 'La :attribute debe ser mayor a la :date.',
            'in' => 'El campo «:attribute» debe ser de tipo :values',
            'same' => 'El campo «:attribute» y :other deben ser iguales.',
            'size' => 'El campo «:attribute» debe tener un tamaño igual a :size.',
            'between' => 'El valor del campo «:attribute» (:input) no está en el rango :min - :max.',
            'max' => 'El campo «:attribute» debe tener un máximo de :max caracteres.',
            'numeric' => 'El campo «:attribute» debe ser un número.',
        ];
    }

    public static function checkTituloRepetido(Request $req)
    {
        if ($req->titulo) {
            $encontrado = DB::table('proyectos')->where('titulo', '=', $req->titulo)->get();
            if ($encontrado->isNotEmpty() && $encontrado[0]->id != $req->idproyecto) {
                return "false"; // No puede usar ese título. La segunda comparación es
                // para que permita modificar el proyecto manteniendo el mismo título.
            }
            return "true"; // El título está disponible
        }
    }
}
