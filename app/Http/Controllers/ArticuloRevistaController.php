<?php

namespace App\Http\Controllers;

use App\Modelos\Persona;
use App\Modelos\Proyecto;
use App\Modelos\Publicaciones\ArticuloRevista;
use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;
use \App\Modelos\Publicaciones\Publicacion;

class ArticuloRevistaController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkPersonaArticuloRevista', ['only' => ['edit']]);
    }

    public function get()
    {
        DB::statement("SET lc_time_names = 'es_ES'");

        $articulos = DB::select('SELECT * FROM tablaarticulos');

        return DataTables::of($articulos)
            ->addColumn('editar', function ($articulo) {
                return '<a href="' . route('articuloRevista.edit', $articulo->id) . '" class="btn btn-xs btn-info"><i class="fas fa-edit"></i></a>';
            })->rawColumns(['editar'])
            ->make(true);
    }

    public function create()
    {
        $proyectos = Proyecto::all();
        return view('publicaciones.articuloRevista.create')->with('proyectos', $proyectos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ArticuloRevistaController::reglasValidacion(), ArticuloRevistaController::mensajes());

        if ($validator->fails()) {
            return redirect('/articuloRevista/create')->withErrors($validator)->withInput();
        } else {
            $publicacion = new Publicacion;
            $publicacion->titulo = $request->titulo;
            $publicacion->idioma = $request->idioma;
            $publicacion->fecha_publicacion = $request->fecha_publicacion;
            $publicacion->doi = $request->doi;
            $publicacion->url = $request->url;
            $publicacion->pais_edicion = $request->pais_edicion;
            $publicacion->ciudad_edicion = $request->ciudad_edicion;
            $publicacion->editorial = $request->editorial;
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

            $articulo = new ArticuloRevista;

            $articulo->titulo_revista = $request->titulo_revista;
            $articulo->referato = $request->referato;
            $articulo->issn = $request->issn;
            $articulo->pag_inicial = $request->pag_inicial;
            $articulo->pag_final = $request->pag_final;
            $articulo->volumen = $request->volumen;
            $articulo->tomo = $request->tomo;
            $articulo->numero = $request->numero;
            $articulo->publicacion()->associate($publicacion);

            $articulo->save();

            return redirect('/publicaciones')->with('exito', 'Artículo de revista guardado exitosamente.');
        }
    }

    public function edit($id)
    {
        $articulo = ArticuloRevista::find($id);
        $proyectos = Proyecto::all();
        return view('publicaciones.articuloRevista.edit')->with('articulo', $articulo)->with('proyectos', $proyectos);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ArticuloRevistaController::reglasValidacion(), ArticuloRevistaController::mensajes());

        if ($validator->fails()) {
            return redirect('/articuloRevista/create')->withErrors($validator)->withInput();
        } else {
            $articulo = ArticuloRevista::find($id);
            $publicacion = $articulo->publicacion;

            $publicacion->titulo = $request->titulo;
            $publicacion->idioma = $request->idioma;
            $publicacion->fecha_publicacion = $request->fecha_publicacion;
            $publicacion->url = $request->url;
            $publicacion->pais_edicion = $request->pais_edicion;
            $publicacion->ciudad_edicion = $request->ciudad_edicion;
            $publicacion->editorial = $request->editorial;
            $publicacion->estado_publicacion = $request->estado_publicacion;

            $request->impreso ? $publicacion->impreso = 1 : $publicacion->impreso = 0;
            $request->digital ? $publicacion->digital = 1 : $publicacion->digital = 0;

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

            $articulo->titulo_revista = $request->titulo_revista;
            $articulo->referato = $request->referato;
            $articulo->issn = $request->issn;
            $articulo->pag_inicial = $request->pag_inicial;
            $articulo->pag_final = $request->pag_final;
            $articulo->volumen = $request->volumen;
            $articulo->tomo = $request->tomo;
            $articulo->numero = $request->numero;
            $articulo->DOI = $request->DOI;

            $articulo->save();

            return redirect('/publicaciones')->with('exito', 'Artículo modificado exitosamente.');
        }
    }

    public function reglasValidacion()
    {
        return [
            'titulo' => 'required|min:3|max:255',
            'titulo_revista' => 'required|min:3|max:255',
            'editorial' => 'required|min:3|max:255',

            'fecha_publicacion' => 'required',

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
