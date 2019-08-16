<?php

namespace App\Http\Controllers;

use App\Modelos\Otros\Institucion;
use App\Modelos\Persona;
use App\Modelos\Proyecto;
use Illuminate\Http\Request;
use Validator;
use \App\Modelos\Publicaciones\Publicacion;
use \App\Modelos\Publicaciones\TesisTesina;
use DB;
use Yajra\DataTables\DataTables;

class TesisTesinaController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkPersonaTesis', ['only' => ['edit']]);
    }

    public function get(Request $request)
    {
        DB::statement("SET lc_time_names = 'es_ES'");

        $tesis_tesinas = DB::select('SELECT * FROM tablatesis');
        return DataTables::of($tesis_tesinas)
            ->addColumn('editar', function ($tesis) {
                return '<a href="' . route('tesisTesina.edit', $tesis->id) . '" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></a>';
            })->rawColumns(['editar'])
            ->make(true);
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return view('publicaciones.tesis.create')->with('proyectos', $proyectos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), TesisTesinaController::reglasValidacion(), TesisTesinaController::mensajes());

        if ($validator->fails()) {
            return redirect('/tesisTesina/create')->withErrors($validator)->withInput();
        } else {
            $publicacion = new Publicacion;
            $publicacion->titulo = $request->titulo;
            $publicacion->idioma = $request->idioma;
            $publicacion->fecha_publicacion = $request->fecha_publicacion;

            $publicacion->resumen = $request->resumen;
            $publicacion->url = $request->url;
            $publicacion->doi = $request->doi;

            $publicacion->resumen = $request->resumen;
            $publicacion->keywords = $request->palabras_claves;

            $institucion = Institucion::firstOrCreate(
                ['institucion' => $request->institucion]
            );
            $publicacion->instituciones_id = $institucion->id;

            $director = Persona::buscar($request->cuit_director);
            if ($director == null) {
                $director = Persona::crear($request->apellido_director, $request->nombre_director, $request->cuit_director);
            }
            $publicacion->director_id = $director->id;

            if ($request->cuit_codirector && $request->nombre_codirector && $request->apellido_codirector) {
                $codirector = Persona::buscar($request->cuit_codirector);
                if ($codirector == null) {
                    $publicacion->codirector_id = Persona::crear($request->nombre_codirector, $request->apellido_codirector, $request->cuit_codirector)->id;
                } else {
                    $publicacion->codirector_id = $codirector->id;
                }
            }

            $request->id_proyecto ? $publicacion->proyectos_id = Proyecto::find($request->id_proyecto)->id : '';

            $publicacion->save();
            $publicacion = Publicacion::buscar($request->titulo);

            // Cargar tabla pivote Autor_Publicaciones
            $autor = Persona::buscar($request->cuit_autor);
            if ($autor == null) {
                $autor = Persona::crear($request->apellido_autor, $request->nombre_autor, $request->cuit_autor);
            }
            $publicacion->autores()->attach($autor->id, ['rol' => "Autor"]);

            $tesis = new TesisTesina;

            $tesis->nivel_educativo = $request->nivel_educativo;
            $tesis->titulo_obtenido = $request->titulo_obtenido;
            $tesis->publicacion()->associate($publicacion);

            $tesis->save();

            return redirect('publicaciones')->with('exito', 'Tesis/tesina guardada exitosamente.');
        }
    }

    public function edit($id)
    {
        $tesis = TesisTesina::find($id);
        $proyectos = Proyecto::all();
        return view('publicaciones.tesis.edit')->with('tesis', $tesis)->with('proyectos', $proyectos);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), TesisTesinaController::reglasValidacion(), TesisTesinaController::mensajes());

        if ($validator->fails()) {
            return redirect('/tesisTesina/create')->withErrors($validator)->withInput();
        } else {
            $tesis = TesisTesina::find($id);
            $publicacion = $tesis->publicacion;
            $publicacion->titulo = $request->titulo;
            $publicacion->idioma = $request->idioma;
            $publicacion->fecha_publicacion = $request->fecha_publicacion;

            $publicacion->digital = $request->digital;

            $publicacion->doi = $request->doi;
            $publicacion->resumen = $request->resumen;
            $publicacion->url = $request->url;

            $publicacion->resumen = $request->resumen;
            $publicacion->keywords = $request->palabras_claves;

            $institucion = Institucion::firstOrCreate(
                ['institucion' => $request->institucion]
            );
            $publicacion->instituciones_id = $institucion->id;

            $director = Persona::buscar($request->cuit_director);
            if ($director == null) {
                $director = Persona::crear($request->apellido_director, $request->nombre_director, $request->cuit_director);
            }
            if ($publicacion->director_id != $director->id) {
                $publicacion->director_id = $director->id;
            }

            if ($request->cuit_codirector && $request->nombre_codirector && $request->apellido_codirector) {
                $codirector = Persona::buscar($request->cuit_codirector);
                if ($codirector == null) {
                    $codirector = Persona::crear($request->apellido_director, $request->nombre_director, $request->cuit_director);
                }
                if ($codirector->id != $publicacion->director_id) {
                    $publicacion->director_id = $codirector->id;
                }
            }

            $request->id_proyecto ? $publicacion->proyectos_id = Proyecto::find($request->id_proyecto)->id : '';

            $publicacion->save();
            $publicacion = Publicacion::buscar($request->titulo);

            // Para la tesis trabajo con un único autor -- ver si es necesario agregar más.
            $autor = Persona::buscar($request->cuit_autor);
            if ($autor == null) {
                $autor = Persona::crear($request->apellido_autor, $request->nombre_autor, $request->cuit_autor);
            }
            if ($autor->id != $publicacion->autores[0]->id) {
                $publicacion->autores()->detach();
                $publicacion->autores()->attach($autor->id, ['rol' => "Autor"]);
                $publicacion->save();
            }

            $tesis->nivel_educativo = $request->nivel_educativo;
            $tesis->titulo_obtenido = $request->titulo_obtenido;

            $tesis->save();

            return redirect('publicaciones')->with('exito', 'Tesis/tesina guardada exitosamente.');
        }
    }

    public function reglasValidacion()
    {
        return [
            'titulo' => 'required|min:3|max:255',
            'nivel_educativo' => 'required',
            'idioma' => 'required|min:3|max:45',
            'fecha_publicacion' => 'required',

            'institucion' => 'required',

            'apellido_director' => 'required',
            'nombre_director' => 'required',
            'cuit_director' => 'required',

            'apellido_autor' => 'required',
            'nombre_autor' => 'required',
            'cuit_autor' => 'required',
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
