<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelos\Persona;
use App\Modelos\Proyecto;
use App\Modelos\Publicaciones\Libro;
use App\Modelos\Publicaciones\ArticuloRevista;
use App\Modelos\Publicaciones\TesisTesina;
use App\Modelos\Publicaciones\TrabajoEvento;


class ReporteController extends Controller
{
    public function index(){
        $autores = Persona::all('id','apellido','nombre');
        return view('reportes.index')->with('autores',$autores);
    }

    ///Recibe un id y devuelve todos los tipos de proyectos asociados a esa persona
    public function getProyectosTipo($id=0){
        $proyectosTipo['data'] = Proyecto::getProyectosById($id);
        echo json_encode($proyectosTipo);
        exit;
      }

      public function poblarElementosSegunProyecto($id=0,$seleccionProyecto='all'){
          if ($seleccionProyecto=='all'){
              $elementosProyecto['data'] = Proyecto::buscarTodosProyectosId($id);
          }else{
              $elementosProyecto['data'] = Proyecto::buscarPorIdTipoProyecto($id,$seleccionProyecto);
          }
        echo json_encode($elementosProyecto);
        exit;
    }

    public function personaProyectoExtension($personaId = 0, $proyecto = 0)
    {
        $resultadoJoin['data'] = Proyecto::joinPersonaProyectoExtension($personaId,$proyecto);
        echo json_encode($resultadoJoin);
        exit;
    }

    public function personaProyectosVarios($personaId = 0, $proyecto = 0)
    {
        $resultadoJoin['data'] = Proyecto::joinPersonaProyecto($personaId,$proyecto);
        echo json_encode($resultadoJoin);
        exit;
    }

    //vamos a comenzar con las funciones para las publicaciones desde acá
    public function poblarElementosSegunPublicacion($id=0,$seleccionPublicacion='all'){
        switch ($seleccionPublicacion) {
            case 'libros':
                $elementosPublicaciones['data'] = Libro::buscarLibrosPorId($id);
                break;
            case 'revistas':
                $elementosPublicaciones['data'] = ArticuloRevista::buscarArtPorId($id);
                break;
            case 'posgrados':
                $elementosPublicaciones['data'] = TesisTesina::buscarTTPorId($id);
                break;
            case 'grado':
                $elementosPublicaciones['data'] = TesisTesina::buscarTTPorId($id);
                break;
            case 'congresos':
                $elementosPublicaciones['data'] = TrabajoEvento::buscarTrabajoPorId($id);
                break;
            default:
                break;
        }
      echo json_encode($elementosPublicaciones);
      exit;
  }
  
    public function libroPorAutorId($autorId=0,$publicacionLibroId='0'){
        $elementosPublicaciones['autores'] =  Libro::traerAutores($publicacionLibroId);
        $elementosPublicaciones['data'] = Libro::buscarLibroPorIdAutor($autorId,$publicacionLibroId);
        echo json_encode($elementosPublicaciones);
        exit;
    }

    
    public function ArticuloRevistaPorAutorId($autorId=0,$publicacionArtRevistaId='0'){
        $elementosPublicaciones['autores'] = Libro::traerAutores($publicacionArtRevistaId);
        $elementosPublicaciones['data'] = ArticuloRevista::buscarArticuloPorIdAutor($autorId,$publicacionArtRevistaId);
        echo json_encode($elementosPublicaciones);
        exit;
    }
    public function GradoPorAutorId($autorId=0,$GradoArtRevistaId='0'){
        $elementosPublicaciones['autores'] = Libro::traerAutores($GradoArtRevistaId);
        $elementosPublicaciones['data'] = TesisTesina::buscarGradoPorIdAutor($autorId,$GradoArtRevistaId);
        echo json_encode($elementosPublicaciones);
        exit;
    }
    
    public function CongresosPorAutorId1($autorId=0,$congresosPorAutorId='0'){
        $elementosPublicaciones['autores'] = Libro::traerAutores($congresosPorAutorId);
        $elementosPublicaciones['data'] = TrabajoEvento::congresosPorIdAutor($autorId,$congresosPorAutorId);
        echo json_encode($elementosPublicaciones);
        exit;
    }

}
