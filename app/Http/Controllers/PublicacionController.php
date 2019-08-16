<?php

namespace App\Http\Controllers;

use App\Modelos\Publicaciones\Publicacion;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use DB;

class PublicacionController extends Controller
{
    public function getPublicaciones()
    {
        $publicaciones = Publicacion::query();
        return DataTables::of($publicaciones)->make(true);
    }

    public function index()
    {
        return view('publicaciones.index');
    }

    public function destroy($id)
    {
        Publicacion::findOrFail($id)->delete();
        return redirect('/publicaciones')->with('borrado_publicacion_exitoso', 'Publicación eliminada.');;
    }

    public static function checkTituloRepetido(Request $req)
    {
        if ($req->titulo) {
            $encontrado = DB::table('publicaciones')->where('titulo', '=', $req->titulo)->get();
            if ($encontrado->isNotEmpty() && $encontrado[0]->id != $req->idproyecto) {
                return "false";
            }
            return "true";
        }
    }
}
