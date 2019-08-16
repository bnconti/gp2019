<?php

namespace App\Http\Controllers;

use App\Modelos\Persona;
use App\Modelos\Proyecto;
use App\Modelos\Publicaciones\Libro;
use App\Modelos\Publicaciones\Publicacion;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;
use DB;

class LibroController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkPersonaLibro', ['only' => ['edit']]);
    }

    public function get()
    {
        $libros = DB::select('SELECT * FROM tablalibros');

        return DataTables::of($libros)
            ->addColumn('editar', function ($libro) {
                return '<a href="' . route('libro.edit', $libro->id) . '" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></a>';
            })->rawColumns(['editar'])
            ->make(true);
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return view('publicaciones.libro.create')->with('proyectos', $proyectos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), LibroController::reglasValidacion(), LibroController::mensajes());

        if ($validator->fails()) {
            return redirect('/libro/create')->withErrors($validator)->withInput();
        } else {
            $publicacion = new Publicacion;

            $publicacion->titulo = $request->titulo;
            $publicacion->idioma = $request->idioma;
            $publicacion->fecha_publicacion = $request->fecha_publicacion;

            $request->impreso ? $publicacion->impreso = 1 : $publicacion->impreso = 0;
            $request->digital ? $publicacion->digital = 1 : $publicacion->digital = 0;

            $publicacion->pais_edicion = $request->pais_edicion;
            $publicacion->editorial = $request->editorial;
            $publicacion->ciudad_edicion = $request->ciudad_edicion;
            $publicacion->estado_publicacion = $request->estado_publicacion;

            $publicacion->doi = $request->doi;
            $publicacion->url = $request->url;
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

            $libro = new Libro;

            $libro->ISBN = $request->ISBN;
            $libro->cant_volumenes = $request->cant_volumenes;
            $libro->cant_pags = $request->cant_pags;
            $libro->referato = $request->referato;

            // Asocio la Publicación con el Libro y guardo.
            $libro->publicacion()->associate($publicacion);
            $libro->save();

            return redirect('/publicaciones')->with('exito', 'Libro guardado exitosamente.');
        }
    }

    public function edit($id)
    {
        $libro = Libro::find($id);
        $proyectos = Proyecto::all();
        return view('publicaciones.libro.edit')->with('proyectos', $proyectos)->with('libro', $libro);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), LibroController::reglasValidacion(), LibroController::mensajes());

        if ($validator->fails()) {
            return redirect('/libro/create')->withErrors($validator)->withInput();
        } else {
            $libro = Libro::find($id);
            $publicacion = $libro->publicacion;

            $publicacion->titulo = $request->titulo;
            $publicacion->idioma = $request->idioma;
            $publicacion->fecha_publicacion = $request->fecha_publicacion;

            $request->impreso ? $publicacion->impreso = 1 : $publicacion->impreso = 0;
            $request->digital ? $publicacion->digital = 1 : $publicacion->digital = 0;

            $publicacion->pais_edicion = $request->pais_edicion;
            $publicacion->editorial = $request->editorial;
            $publicacion->ciudad_edicion = $request->ciudad_edicion;
            $publicacion->estado_publicacion = $request->estado_publicacion;

            $publicacion->doi = $request->doi;
            $publicacion->url = $request->url;
            $publicacion->resumen = $request->resumen;
            $publicacion->keywords = $request->palabras_claves;

            $request->id_proyecto ? $publicacion->proyectos_id = Proyecto::find($request->id_proyecto)->id : $publicacion->proyectos_id = null;

            $publicacion->save();

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

            $libro->ISBN = $request->ISBN;
            $libro->cant_volumenes = $request->cant_volumenes;
            $libro->cant_pags = $request->cant_pags;
            $libro->referato = $request->referato;

            $libro->save();

            return redirect('/publicaciones')->with('exito', 'Libro modificado exitosamente.');
        }
    }

    public function reglasValidacion()
    {
        return [
            'titulo' => 'required|min:3|max:255',
            'idioma' => 'required|min:3|max:45',
            'fecha_publicacion' => 'required',

            'pais_edicion' => 'required',
            'editorial' => 'required',

            'cant_pags' => 'required|min:3|max:45',

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
