<?php

namespace App\Modelos\Publicaciones;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Publicacion extends Model
{
    use Notifiable;

    protected $table = 'publicaciones';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'titulo', 'idioma', 'fecha_publicacion', 'url', 'resumen',
        'keywords', 'pais_edicion', 'ciudad_edicion', 'editorial',
        'estado_publicacion', 'impreso', 'digital', 'doi'
    ];

    // Obtener el proyecto al que pertenece la publicación
    public function proyecto()
    {
        return $this->belongsTo('App\Modelos\Proyecto', 'proyectos_id', 'id');
    }

    // Obtener el director del proyecto
    public function director()
    {
        return $this->belongsTo('App\Modelos\Persona', 'director_id', 'id');
    }

    // Obtener el codirector del proyecto
    public function codirector()
    {
        return $this->belongsTo('App\Modelos\Persona', 'codirector_id', 'id');
    }

    public function institucion()
    {
        return $this->belongsTo('App\Otros\Institucion', 'instituciones_id', 'id');
    }

    public function autores()
    {
        return $this->belongsToMany(
            'App\Modelos\Persona',
            'autor_publicaciones',
            'publicaciones_id',
            'persona_id'
        )->withPivot('rol');
    }

    public function tesis()
    {
        return $this->belongsTo('App\Modelos\Publicaciones\TesisTesina');
    }

    public function libro()
    {
        return $this->belongsTo('App\Modelos\Publicaciones\Libro');
    }

    public function parteLibro()
    {
        return $this->belongsTo('App\Modelos\Publicaciones\ParteLibro');
    }

    public function trabajoEvento()
    {
        return $this->belongsTo('App\Modelos\Publicaciones\TrabajoEvento');
    }

    public function articulo()
    {
        return $this->belongsTo('App\Modelos\Publicaciones\ArticuloRevista');
    }

    public static function buscar($titulo) {
        return Publicacion::where('titulo', $titulo)->first();
    }

}

abstract class Idioma
{
    const Idioma1 = "Idioma 1";
    const Idioma2 = "Idioma 2";
}

abstract class Pais
{
    const Pais1 = "Pais 1";
    const Pais2 = "Pais 2";
}

abstract class MedioDifusion
{
    const MedioDifusion1 = "Medio de Difusión 1";
    const MedioDifusion2 = "Medio de Difusión 2";
}
