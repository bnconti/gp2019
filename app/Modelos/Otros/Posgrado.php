<?php

namespace App\Modelos\Otros;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Posgrado extends Model
{
    use Notifiable;

    protected $table = 'titulo';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grado'
    ];

}

?>