<?php

namespace App\Modelos\Publicaciones;

use Illuminate\Notifications\Notifiable;
use DB;

class TesisTesina extends Publicacion
{
    use Notifiable;

    protected $table = 'tesis_tesinas';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'nivel_educativo', 'titulo_obtenido'
    ];

    public function publicacion()
    {
      return $this->belongsTo('App\Modelos\Publicaciones\Publicacion', 'publicaciones_id');
    }

    public static function buscarTTPorId($id){
      $value = DB::select( 
            DB::raw("SELECT * FROM autor_publicaciones 
                INNER JOIN persona ON autor_publicaciones.persona_id=persona.id
                INNER JOIN publicaciones ON autor_publicaciones.publicaciones_id=publicaciones.id
                Inner join tesis_tesinas on tesis_tesinas.publicaciones_id=publicaciones.id
              WHERE autor_publicaciones.persona_id=:idautor"
        ),array(
            'idautor'=>$id
        ) );
        return $value;
    }      
    

    public static function buscarGradoPorIdAutor($autorId,$GradoArtRevistaId){
      $value = DB::select( 
            DB::raw("SELECT * FROM autor_publicaciones 
              INNER JOIN persona ON autor_publicaciones.persona_id=persona.id
              INNER JOIN publicaciones ON autor_publicaciones.publicaciones_id=publicaciones.id
              Inner join tesis_tesinas on tesis_tesinas.publicaciones_id=publicaciones.id
              inner join instituciones on instituciones.id = publicaciones.instituciones_id
              WHERE autor_publicaciones.persona_id=:idautor AND tesis_tesinas.publicaciones_id=:idpublicacion"
        ),array(
            'idautor'=>$autorId,
            'idpublicacion'=>$GradoArtRevistaId
        ) );
        return $value;
    }  
}
/*     public function autores()
    {
      return $this->hasManyThrough('App\Modelos\Persona', 'App\Modelos\Publicaciones\Publicacion', )
    }
 */