<?php

namespace App\Modelos\Publicaciones;

use Illuminate\Notifications\Notifiable;
use DB;

class ArticuloRevista extends Publicacion
{
    use Notifiable;

    protected $table = 'revistas_articulos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'referato', 'titulo_revista', 'issn', 'pag_inicial', 'pag_final', 'volumen',
        'tomo', 'numero'
    ];

    public function publicacion()
    {
      return $this->belongsTo('App\Modelos\Publicaciones\Publicacion', 'publicaciones_id');
    }

    public static function buscarArtPorId($id){
      $value = DB::select( 
            DB::raw("SELECT * FROM autor_publicaciones 
                INNER JOIN persona ON autor_publicaciones.persona_id=persona.id
                INNER JOIN publicaciones ON autor_publicaciones.publicaciones_id=publicaciones.id
                Inner join revistas_articulos on revistas_articulos.publicaciones_id=publicaciones.id
                WHERE autor_publicaciones.persona_id=:idautor"
        ),array(
            'idautor'=>$id
        ) );
        return $value;
    }      
    
    public static function buscarArticuloPorIdAutor($autorId,$publicacionArtId){
        $value = DB::select( 
              DB::raw("SELECT * FROM autor_publicaciones 
                INNER JOIN persona ON autor_publicaciones.persona_id=persona.id
                INNER JOIN publicaciones ON autor_publicaciones.publicaciones_id=publicaciones.id
                Inner join revistas_articulos on revistas_articulos.publicaciones_id=publicaciones.id
                WHERE autor_publicaciones.persona_id=:idautor AND revistas_articulos.publicaciones_id=:idpublicacion"
          ),array(
              'idautor'=>$autorId,
              'idpublicacion'=>$publicacionArtId
          ) );
          return $value;
      }  
}