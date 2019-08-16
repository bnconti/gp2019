<?php

namespace App\Modelos\Publicaciones;

use Illuminate\Notifications\Notifiable;
use DB;

class TrabajoEvento extends Publicacion
{
    use Notifiable;

    protected $table = 'trabajos_en_eventos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'tipo_trabajo', 'tipo_publicacion', 'titulo_librorevista', 'ISSN_ISBN',
        'nombre_evento', 'tipo_evento', 'alcance_geografico','pais_evento',
        'ciudad_evento','fecha_evento','institucion_organizadora'
    ];

    public function publicacion()
    {
      return $this->belongsTo('App\Modelos\Publicaciones\Publicacion', 'publicaciones_id');
    }

    public static function buscarTrabajoPorId($id){
      $value = DB::select( 
            DB::raw("SELECT * FROM autor_publicaciones 
                INNER JOIN persona ON autor_publicaciones.persona_id=persona.id
                INNER JOIN publicaciones ON autor_publicaciones.publicaciones_id=publicaciones.id
                Inner join trabajos_en_eventos on trabajos_en_eventos.publicaciones_id=publicaciones.id
                WHERE autor_publicaciones.persona_id=:idautor"
        ),array(
            'idautor'=>$id
        ) );
        return $value;
    }      
    
    public static function congresosPorIdAutor($autorId,$congresosPorAutorId){
        $value = DB::select( 
              DB::raw("SELECT * FROM autor_publicaciones 
                INNER JOIN persona ON autor_publicaciones.persona_id=persona.id
                INNER JOIN publicaciones ON autor_publicaciones.publicaciones_id=publicaciones.id
                Inner join trabajos_en_eventos on trabajos_en_eventos.publicaciones_id=publicaciones.id
                WHERE autor_publicaciones.persona_id=:idautor AND trabajos_en_eventos.publicaciones_id=:idpublicacion"
          ),array(
              'idautor'=>$autorId,
              'idpublicacion'=>$congresosPorAutorId
          ) );
          return $value;
      } 
}