<?php

namespace App\Modelos\Publicaciones;

use Illuminate\Notifications\Notifiable;

class ParteLibro extends Publicacion
{
    use Notifiable;

    protected $table = 'partes_libros';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'titulo_parte', 'tipo_parte', 'ISBN',
        'volumen','tomo','num','cant_pags','pag_inicial','pag_final',
        'referato'
    ];

    public function publicacion()
    {
      return $this->belongsTo('App\Modelos\Publicaciones\Publicacion', 'publicaciones_id');
    }
}