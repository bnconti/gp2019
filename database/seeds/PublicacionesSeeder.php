<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class PublicacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 1; $i <= 25; $i++) {
            DB::table('publicaciones')->insert([
                'titulo' => $faker->sentence(4),
                'idioma' => "Español",
                'fecha_publicacion' => $faker->date,
                'medio_difusion' => Arr::random(['Papel', 'Digital', 'Papel y digital']),
                'resumen' => $faker->text,
                'keywords' => $faker->word . ", " . $faker->word . ", " . $faker->word,
                'instituciones_id' => 1,
                'pais_edicion' => Arr::random(['Argentina', 'Brasil', 'España']),
                'estado_publicacion' => Arr::random(['Publicado', 'En prensa']),
                'codirector_id' => random_int(1, 5),
                'director_id' => random_int(1, 5),
                'proyectos_id' => random_int(1, 20),
            ]);
        }
    }
}
