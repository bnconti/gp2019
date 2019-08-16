<?php

namespace App\Modelos;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Usuario extends Model
{
    use Notifiable;
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'mail_itt', 'gmail', 'rol', 'cargo', 'dedicacion', 'persona', 'borrado', 'aceptado', 'password', 'es_admin'
    ];

    // El Usuario tiene una Persona
    public function persona()
    {
        return $this->hasOne('App\Modelos\Persona', 'usuarios_id');
    }

    public static function checkUser($userData){
        if(!empty($userData)){
            // Check whether user data already exists in the database
            $checkResult = DB::table('users')
                ->select()
                ->where('oauth_provider', '=', 'google')
                ->where('oauth_uid', '=', $userData->id)
                ->get();

            if($checkResult->count()) {
                $first = get_object_vars($checkResult->first());
                // Update user data if already exists
                DB::table('users')
                    ->where('oauth_provider', $first['oauth_provider'])
                    ->where('oauth_uid', $first['oauth_uid'])
                    ->update([
                        'oauth_provider' => $first['oauth_provider'],
                        'oauth_uid' => $first['oauth_uid'],
                        'first_name' => $first['first_name'],
                        'last_name' => $first['last_name'],
                        'email' => $first['email'],
                        'gender' => $first['gender'],
                        'locale' => $first['locale'],
                        'picture' => $first['picture'],
                        'link' => $first['link'],
                        'created' => NOW(),
                        'modified' => NOW(),
                    ]);
            } else {
                // Insert user data in the database
                DB::table('users')->insert(
                    [
                        'oauth_provider' => 'google',
                        'oauth_uid' => $userData->id,
                        'first_name' => $userData->user['given_name'],
                        'last_name' => $userData->user['family_name'],
                        'email' => $userData->email,
                        'gender' => !empty($userData->user['gender'])?$userData->user['gender']:'',
                        'locale' => $userData->user['locale'],
                        'picture' => $userData->user['picture'],
                        'link' => !empty($userData->user['link'])?$userData->user['link']:'',
                        'created' => NOW(),
                        'modified' => NOW(),
                    ]
                );
                $nombreCompleto = $userData->user['given_name'];
                $nombreCompletoSeparado = explode(" ", $userData->user['given_name']);
                $iniciales = "";
                foreach ($nombreCompletoSeparado as $nombre) {
                    $iniciales = $iniciales . $nombre[0];
                }
                $mail_itt = strtolower($iniciales.$userData->user['family_name'].'@comunidad.unnoba.edu.ar');
                $usuarioId = DB::table('usuarios')->insertGetId (
                    [
                        'mail_itt' => $mail_itt,
                        'gmail' => $userData->email,
                        'rol' => 'Sin definir',
                        'cargo' => 'Sin definir',
                        'dedicacion' => 'Sin definir',
                        'aceptado' => 0,
                        'es_admin' => 0,
                    ]
                );
                DB::table('persona')->insert(
                    [
                        'nombre' => $userData->user['given_name'],
                        'apellido' => $userData->user['family_name'],
                        'cuit_cuil' => '-',
                        'usuarios_id' => $usuarioId
                    ]
                );
            }
        }

        // Return user data
        return $userData;
    }

    public static function getUserLocal($userData = array()) {
        if(!empty($userData)){
            // Check whether user data already exists in the database
            $userLocal = DB::table('usuarios')
                ->select()
                ->where('gmail', '=', $userData['email'])
                ->get();
        }

        // Return user data
        return $userLocal;
    }

    public static function buscarPorId($userId) {
        $user = Usuario::where('id', $userId)->first();
        return $user;
    }
}


abstract class Cargos
{
    const Cargo1 = "Cargo 1";
    const Cargo2 = "Cargo 2";
}

abstract class Dedicacion
{
    const Dedicacion1 = "Dedicacion 1";
    const Dedicacion2 = "Dedicacion 2";
}

abstract class Rol
{
    const Rol1 = "Rol 1";
    const Rol2 = "Rol 2";
}
