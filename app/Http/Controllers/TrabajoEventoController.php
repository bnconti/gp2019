<?php

namespace App\Http\Controllers;

use App\Modelos\Persona;
use App\Modelos\Proyecto;
use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;
use \App\Modelos\Publicaciones\Publicacion;
use \App\Modelos\Publicaciones\TrabajoEvento;

class TrabajoEventoController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkPersonaTrabajoEnEvento', ['only' => ['edit']]);
    }

    public function get()
    {
        $trabajos = DB::select('SELECT * FROM tablatrabajos');
        return DataTables::of($trabajos)
            ->addColumn('editar', function ($trabajo) {return '<a href="' . route('trabajoEvento.edit', $trabajo->id) . '" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></a>';
            })->rawColumns(['editar'])
            ->make(true);
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return view('publicaciones.trabajoenevento.create')->with('proyectos', $proyectos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), TrabajoEventoController::reglasValidacion(), TrabajoEventoController::mensajes());

        if ($validator->fails()) {
            return redirect('/trabajoEvento/create')->withErrors($validator)->withInput();
        } else {
            $publicacion = new Publicacion;

            $publicacion->titulo = $request->titulo;
            $publicacion->idioma = $request->idioma;
            $publicacion->fecha_publicacion = $request->fecha_publicacion;

            $publicacion->resumen = $request->resumen;
            $publicacion->url = $request->url;
            $publicacion->doi = $request->doi;

            $publicacion->pais_edicion = $request->pais_edicion;
            $publicacion->editorial = $request->editorial;
            $publicacion->ciudad_edicion = $request->ciudad_edicion;
            $publicacion->estado_publicacion = $request->estado_publicacion;

            $request->impreso ? $publicacion->impreso = 1 : $publicacion->impreso = 0;
            $request->digital ? $publicacion->digital = 1 : $publicacion->digital = 0;

            $publicacion->resumen = $request->resumen;
            $publicacion->keywords = $request->palabras_claves;

            $request->id_proyecto ? $publicacion->proyectos_id = Proyecto::find($request->id_proyecto)->id : '';

            $publicacion->save();

            $cant_autores = count($request->cuit_autor);

            for ($i = 0; $i < $cant_autores; $i++) {
                $persona = Persona::buscar($request->cuit_autor[$i]);
                if ($persona == null) {
                    $persona = Persona::crear($request->apellido_autor[$i], $request->nombre_autor[$i], $request->cuit_autor[$i]);
                }
                $publicacion->autores()->attach($persona->id, ['rol' => 'Autor']);
            }

            $trabajo = new TrabajoEvento;

            $trabajo->tipo_trabajo = $request->tipo_trabajo;
            $trabajo->tipo_publicacion = $request->tipo_publicacion;
            $trabajo->titulo_librorevista = $request->titulo_librorevista;
            $trabajo->nombre_evento = $request->nombre_evento;
            $trabajo->tipo_evento = $request->tipo_evento;
            $trabajo->alcance_geografico = $request->alcance_geografico;
            $trabajo->pais_evento = $request->pais_evento;
            $trabajo->fecha_evento = $request->fecha_evento;
            $trabajo->ciudad_evento = $request->ciudad_evento;
            $trabajo->ISSN_ISBN = $request->ISSN_ISBN;
            $trabajo->institucion_organizadora = $request->institucion_organizadora;
            $trabajo->publicacion()->associate($publicacion);

            $trabajo->save();

            return redirect('/publicaciones')->with('exito', 'Trabajo de evento guardado exitosamente.');
        }
    }

    public function edit($id)
    {
        $trabajo = TrabajoEvento::find($id);
        $proyectos = Proyecto::all();
        return view('publicaciones.trabajoenevento.edit')->with('proyectos', $proyectos)->with('trabajo', $trabajo);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), TrabajoEventoController::reglasValidacion(), TrabajoEventoController::mensajes());

        if ($validator->fails()) {
            return redirect('/trabajoEvento/create')->withErrors($validator)->withInput();
        } else {
            $trabajo = TrabajoEvento::find($id);
            $publicacion = $trabajo->publicacion;

            $publicacion->titulo = $request->titulo;
            $publicacion->idioma = $request->idioma;
            $publicacion->fecha_publicacion = $request->fecha_publicacion;

            $publicacion->resumen = $request->resumen;
            $publicacion->url = $request->url;
            $publicacion->doi = $request->doi;

            $publicacion->pais_edicion = $request->pais_edicion;
            $publicacion->editorial = $request->editorial;
            $publicacion->ciudad_edicion = $request->ciudad_edicion;
            $publicacion->estado_publicacion = $request->estado_publicacion;

            $request->impreso ? $publicacion->impreso = 1 : $publicacion->impreso = 0;
            $request->digital ? $publicacion->digital = 1 : $publicacion->digital = 0;

            $publicacion->resumen = $request->resumen;
            $publicacion->keywords = $request->palabras_claves;

            // Actualizo el Proyecto asociado
            $request->id_proyecto ? $publicacion->proyectos_id = Proyecto::find($request->id_proyecto)->id : $publicacion->proyectos_id = null;

            $publicacion->save();

            // Actualizo los autores asociados
            $cant_autores = count($request->cuit_autor);
            $idAutores = collect();

            for ($i = 0; $i < $cant_autores; $i++) {
                $persona = Persona::buscar($request->cuit_autor[$i]);

                if ($persona == null) {
                    $persona = Persona::crear($request->apellido_autor[$i], $request->nombre_autor[$i], $request->cuit_autor[$i]);
                }

                $idAutores->add($persona->id);
            }

            $publicacion->autores()->sync($idAutores->values());

            $trabajo->tipo_trabajo = $request->tipo_trabajo;
            $trabajo->tipo_publicacion = $request->tipo_publicacion;
            $trabajo->titulo_librorevista = $request->titulo_librorevista;
            $trabajo->nombre_evento = $request->nombre_evento;
            $trabajo->tipo_evento = $request->tipo_evento;
            $trabajo->alcance_geografico = $request->alcance_geografico;
            $trabajo->pais_evento = $request->pais_evento;
            $trabajo->fecha_evento = $request->fecha_evento;
            $trabajo->ciudad_evento = $request->ciudad_evento;
            $trabajo->ISSN_ISBN = $request->ISSN_ISBN;
            $trabajo->institucion_organizadora = $request->institucion_organizadora;

            $trabajo->save();

            return redirect('/publicaciones')->with('exito', 'Trabajo de evento modificado exitosamente.');
        }
    }

    public function reglasValidacion()
    {
        return [
            'titulo' => 'required|min:3|max:255',
            'idioma' => 'required|min:3|max:45',
            'fecha_publicacion' => 'required',

            'tipo_trabajo' => 'required|min:3|max:45',
            'tipo_publicacion' => 'required|min:3|max:45',
            'titulo_librorevista' => 'required|min:3|max:45',

            'nombre_evento' => 'required|min:3|max:100',
            'tipo_evento' => 'required|min:3|max:45',
            'alcance_geografico' => 'required|min:3|max:45',
            'pais_evento' => 'required|min:3|max:45',
            'fecha_evento' => 'required',
            'institucion_organizadora' => 'required',

            'apellido_autor.0' => 'required',
            'nombre_autor.0' => 'required',
            'cuit_autor.0' => 'required',
        ];
    }

    public function mensajes()
    {
        return [
            'required' => 'El campo «:attribute» es requerido.',
            'min' => 'El campo «:attribute» debe tener un mínimo de :min caracteres.',
            'after' => 'La :attribute debe ser anterior a la :date.',
            'in' => 'El campo «:attribute» debe ser de tipo :values',
            'same' => 'El campo «:attribute» y :other deben ser iguales.',
            'size' => 'El campo «:attribute» debe tener un tamaño igual a :size.',
            'between' => 'El valor del campo «:attribute» (:input) no está en el rango :min - :max.',
            'max' => 'El campo «:attribute» debe tener un máximo de :max caracteres.',
            'numeric' => 'El campo «:attribute» debe ser un número.',
        ];
    }
}
