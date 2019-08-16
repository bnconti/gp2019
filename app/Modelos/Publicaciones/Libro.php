<?php

namespace App\Modelos\Publicaciones;

use Illuminate\Notifications\Notifiable;
use DB;

class Libro extends Publicacion
{
    use Notifiable;

    protected $table = 'libros';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'ISBN', 'cant_volumenes', 'cant_pags', 'referato'
    ];

    public function publicacion()
    {
      return $this->belongsTo('App\Modelos\Publicaciones\Publicacion', 'publicaciones_id');
    }

    public static function traerAutores($id){
      $value = DB::select( 
        DB::raw("SELECT * FROM autor_publicaciones INNER JOIN persona on autor_publicaciones.persona_id=persona.id
        WHERE publicaciones_id=:idpublicacion "
    ),array(
        'idpublicacion'=>$id
    ) );
    return $value;
    }

    public static function buscarLibrosPorId($id){
      $value = DB::select( 
            DB::raw("SELECT * FROM autor_publicaciones 
            INNER JOIN persona ON autor_publicaciones.persona_id=persona.id
              INNER JOIN publicaciones ON autor_publicaciones.publicaciones_id=publicaciones.id
              INNER JOIN libros ON libros.publicaciones_id=publicaciones.id
            WHERE autor_publicaciones.persona_id=:idautor"
        ),array(
            'idautor'=>$id
        ) );
        return $value;
    }      

    public static function buscarLibroPorIdAutor($autorId,$publicacionLibroId){
        $value = DB::select( 
              DB::raw("SELECT * FROM autor_publicaciones 
              INNER JOIN persona ON autor_publicaciones.persona_id=persona.id
              INNER JOIN publicaciones ON autor_publicaciones.publicaciones_id=publicaciones.id
              INNER JOIN libros ON libros.publicaciones_id=publicaciones.id
              WHERE autor_publicaciones.persona_id=:idautor AND autor_publicaciones.publicaciones_id=:idpublicacion"
          ),array(
              'idautor'=>$autorId,
              'idpublicacion'=>$publicacionLibroId
          ) );
          return $value;
      }  

}