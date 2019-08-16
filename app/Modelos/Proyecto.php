<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use DB;

class Proyecto extends Model
{
    use Notifiable;

    protected $table = 'proyectos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'titulo', 'resolucion', 'expediente', 'tipo_actividad', 'tipo_proyecto',
        'desde', 'hasta', 'descripcion', 'director_id', 'codirector_id'
    ];

    public function director()
    {
        return $this->belongsTo('\App\Modelos\Persona', 'director_id', 'id');
    }

    public function codirector()
    {
        return $this->belongsTo('App\Modelos\Persona', 'codirector_id', 'id');
    }

    public function participantes()
    {
        return $this->belongsToMany(
            'App\Modelos\Persona',
            'personas_proyectos',
            'proyectos_id',
            'personas_id'
        )->withPivot('funcion_desempeniada', 'inicio_participacion', 'fin_participacion');
    }

    public static function buscar($cod)
    {
        return Proyecto::where('cod_identificacion', $cod)->first();
    }

    public static function getProyectosById($id=0){

        $value=DB::table('proyectos')
            ->select('tipo_proyecto')    
            ->where('director_id', $id)
            ->groupBy('tipo_proyecto')
            ->get();
        return $value;
    }

    public static function buscarPorIdTipoProyecto($id=0,$seleccion='all'){
          
        $value=DB::table('proyectos')
        ->where(function($query) use ($id) {
            $query ->where('director_id','=',$id);
        })->where('tipo_proyecto','=',$seleccion)
        ->get();
        return $value;
    }

    public static function buscarTodosProyectosId($id){
        $value=DB::table('proyectos')
            ->where('director_id','=', $id)
            ->get();
        return $value;
    }
    public static function joinPersonaProyectoExtension($idPersona,$idProyectoExtension){
        $value = DB::select( 
            DB::raw("SELECT * FROM persona 
            INNER JOIN proyectos ON persona.id = proyectos.director_id 
            WHERE persona.id=:persona AND proyectos.id=:proyecto "
        ),array(
            'persona'=>$idPersona,
            'proyecto'=>$idProyectoExtension
        ) );
        return $value;
    }

    public static function joinPersonaProyecto($idPersona,$idProyecto){
        //Vista que tenemos que crear
        /**
         * CREATE VIEW codirectorproyecto AS 
         * SELECT persona.id, persona.nombre, persona.apellido, proyectos.id as proyectoid
         * FROM persona INNER JOIN proyectos ON persona.id=proyectos.codirector_id
         */

        $value = DB::select( 
            DB::raw("
                    SELECT *,
                        director.id, director.nombre as dirnombre, director.apellido as dirapellido, director.cuit_cuil as dircuil,
                        pro.id as proid,
                        codirector.nombre as conombre, codirector.apellido as coapellido
                    FROM persona as director
                        INNER JOIN proyectos as pro ON pro.director_id = director.id
                        INNER JOIN codirectorproyecto as codirector ON codirector.id=pro.codirector_id
                    WHERE director.id=:idPersona AND pro.id=:idProyecto"
            ),array( 
                'idPersona' => $idPersona,
                'idProyecto' => $idProyecto
            )
        );
        return $value;
    }

}