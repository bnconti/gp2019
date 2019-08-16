<?php 

namespace App\Modelos\Otros;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Titulo extends Model{

    use Notifiable;

    protected $table = 'titulos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grado', 'titulo'
    ];

  public function instituciones()
 {
     return $this->belongsTo('App\Otros\Institucion', 'instituciones_id', 'id');
 }
 public function titulos()
 {
     return $this->belongsToMany(
         'App\Otros\Titulos',
         'usuarios_titulos',
         'usuarios_id',
         'titulos_id'
     )->withPivot('finalizado');
 }   
}

