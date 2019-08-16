<?php

namespace App\Http\Controllers;

use App\Modelos\Persona;
use App\Modelos\Proyecto;
use App\Modelos\Publicaciones\ParteLibro;
use App\Modelos\Publicaciones\Publicacion;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Validator;
use DB;

class ParteLibroController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkPersonaParteLibro', ['only' => ['edit']]);
    }

    public function get()
    {
        $partes = DB::select('SELECT * FROM tablapartelibros');

        return DataTables::of($partes)
            ->addColumn('editar', function ($parte) {
                return '<a href="' . route('parteLibro.edit', $parte->id) . '" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></a>';
            })->rawColumns(['editar'])
            ->make(true);
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return view('publicaciones.partedelibro.create')->with('proyectos', $proyectos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ParteLibroController::reglasValidacion(), ParteLibroController::mensajes());

        if ($validator->fails()) {
            return redirect('/parteLibro/create')->withErrors($validator)->withInput();
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

            $parte = new ParteLibro;

            $parte->titulo_parte = $request->titulo_parte;
            $parte->tipo_parte = $request->tipo_parte;
            $parte->volumen = $request->volumen;
            $parte->pag_inicial = $request->pag_inicial;
            $parte->pag_final = $request->pag_final;
            $parte->ISBN = $request->ISBN;
            $parte->cant_pags = $request->cant_pags;
            $parte->referato = $request->referato;

            // Asocio la Publicación con el parte y guardo.
            $parte->publicacion()->associate($publicacion);
            $parte->save();

            return redirect('/publicaciones')->with('exito', 'Parte de libro guardada exitosamente.');
        }
    }

    public function edit($id)
    {
        $parte = ParteLibro::find($id);
        $proyectos = Proyecto::all();
        return view('publicaciones.partedelibro.edit')->with('proyectos', $proyectos)->with('parte', $parte);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ParteLibroController::reglasValidacion(), ParteLibroController::mensajes());

        if ($validator->fails()) {
            return redirect('/partelibro/create')->withErrors($validator)->withInput();
        } else {
            $parte = ParteLibro::find($id);
            $publicacion = $parte->publicacion;

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

            $parte->titulo_parte = $request->titulo_parte;
            $parte->tomo = $request->tomo;
            $parte->tipo_parte = $request->tipo_parte;
            $parte->volumen = $request->volumen;
            $parte->pag_inicial = $request->pag_inicial;
            $parte->pag_final = $request->pag_final;
            $parte->ISBN = $request->ISBN;
            $parte->cant_pags = $request->cant_pags;
            $parte->referato = $request->referato;

            $parte->save();

            return redirect('/publicaciones')->with('exito', 'Parte de libro modificada exitosamente.');
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

            'titulo_parte' => 'required',
            'tipo_parte' => 'required',

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
