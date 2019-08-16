<?php 

namespace App\Modelos\Otros;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Entidad extends Model
{
    use Notifiable;

    protected $table = 'entidad';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'entidad'
    ];

    public function proyectos()
    {
        return $this->belongsToMany(
            'App\Modelos\Proyecto',
            'proyectos_entidad',
            'proyectos_id',
            'entidad_id'
        )->withPivot('ejecuta', 'evalua', 'adopta', 'demanda', 'promueve', 'financia');
    }

    public static function buscar($nombre) {
        /* Busca una Entidad a partir de su Nombre */
        return Entidad::where('entidad', $nombre)->first();
    }

    public static function crear($nombre) {
        $nueva_entidad = new Entidad([
            'entidad' => $nombre,
        ]);

        $nueva_entidad->save();
        return Entidad::where('entidad', $nombre)->first(); 
    }
}

