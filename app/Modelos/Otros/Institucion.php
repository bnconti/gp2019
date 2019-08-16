<?php

namespace App\Modelos\Otros;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Institucion extends Model
{
    use Notifiable;

    protected $table = 'instituciones';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'institucion'
    ];

    public static function buscar($nombre) {
        return Institucion::where('institucion', $nombre)->first();
    } 


}
