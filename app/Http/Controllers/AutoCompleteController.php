<?php

namespace App\Http\Controllers;

use App\Modelos\Otros\Entidad;
use Illuminate\Http\Request;
use App\Modelos\Persona;

class AutoCompleteController extends Controller
{
    public function searchEntidad(Request $request)
    {
        $entidades = Entidad::where('entidad', 'LIKE', '%'.$request->search.'%')->get();
        return \response()->json($entidades);
    }

    public function searchPersonaApellido(Request $request)
    {
        $apellidos = Persona::where('apellido', 'LIKE', '%'.$request->search.'%')->get();
        return \response()->json($apellidos);
    }

    public function searchPersonaNombre(Request $request)
    {
        $nombres = Persona::where('nombre', 'LIKE', '%'.$request->search.'%')->get();
        return \response()->json($nombres);
    }

    
    public function searchPersonaCuitCuil(Request $request)
    {
        $cuiles_cuites = Persona::where('cuit_cuil', 'LIKE', '%'.$request->search.'%')->get();
        return \response()->json($cuiles_cuites);
    }
}
