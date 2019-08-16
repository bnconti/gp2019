<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // EntidadSeeder::class,
            UsuariosSeeder::class,
            PersonasSeeder::class,
            ProyectosSeeder::class,
            InstitucionesSeeder::class,
            // PublicacionesSeeder::class,
        ]);
    }
}
