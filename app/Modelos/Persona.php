<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Persona extends Model
{
    use Notifiable;

    protected $table = 'persona';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'apellido', 'nombre', 'cuit_cuil'
    ];

    /**
     * Define la relación Usuario-Persona. Obtener el usuario perteneciente a la persona.
     */
    public function usuario()
    {
        return $this->belongsTo('App\Modelos\Usuario', 'id');
    }

    public function proyectos()
    {
        return $this->belongsToMany(
            'App\Modelos\Proyecto',
            'personas_proyectos',
            'personas_id',
            'proyectos_id'
        )->withPivot('funcion_desempeniada', 'inicio_participacion', 'fin_participacion');
    }

    public function publicaciones()
    {
        return $this->belongsToMany(
            'App\Modelos\Publicaciones\Publicacion',
            'autor_publicaciones',
            'persona_id',
            'publicaciones_id'
        )->withPivot('rol');
    }

    public function titulos()
    {
        return $this->belongsToMany(
            'App\Modelos\Otros\Titulos',
            'usuarios_titulos',
            'usuarios_id',
            'titulos_id'
        )->withPivot('finalizado');
    }

    public static function buscar($cuit) {
        /* Busca una Persona a partir de su CUIT/CUIL/PAS */
        return Persona::where('cuit_cuil', $cuit)->first();
    }

    public static function buscarPorIdUsuario($id) {
        // Retorna el ID de la persona a partir de su ID de usuario (pueden ser distintos)
        $persona = Persona::where('usuarios_id', $id)->first();
        return $persona;
    }

    public static function crear($apellido, $nombre, $cuit, $usuarios_id = null) {
        /* Crea una Persona y la retorna */
        $nueva_persona = new Persona([
            'nombre'        => $nombre,
            'apellido'      => $apellido,
            'cuit_cuil'     => $cuit,
            'usuarios_id'   => $usuarios_id,
        ]);

        $nueva_persona->save();
        return Persona::where('cuit_cuil', $cuit)->first();
    }
}
