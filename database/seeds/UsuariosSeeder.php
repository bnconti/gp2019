<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 12; $i++) {
            DB::table('usuarios')->insert([
                'mail_itt' => $faker->userName . "@comunidad.unnoba.edu.ar",
                'gmail' => $faker->userName . "@gmail.com",
                'rol' => Arr::random(['Investigador', 'Alumno becado']),
                'cargo' => Arr::random(['Jefe', 'Miembro']),
                'dedicacion' => 'Investigar',
                'aceptado' => 0,
                'es_admin' => 0,
            ]);
        }
    }
}
