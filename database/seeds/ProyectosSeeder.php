<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

use App\Modelos\Proyecto;

class ProyectosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('es_ES');

        for ($i = 1; $i <= 6; $i++) {
            
            DB::table('proyectos')->insert([
                'titulo' => $faker->sentence(3, false),
                'cod_identificacion' => 'P' . $faker->numberBetween($min = 1000, $max = 9999),
                'resolucion' => $faker->numberBetween($min = 1000, $max = 4999) . "/" . $faker->numberBetween($min = 2011, $max = 2019),
                'expediente' => $faker->numberBetween($min = 100, $max = 499) . "/" . $faker->numberBetween($min = 2011, $max = 2019),
                
                'tipo_actividad' => Arr::random(['Investigación básica', 'Investigación aplicada', 'Desarrollo experimental o tecnológico']),
                'tipo_proyecto' => Arr::random(['Extensión', 'Voluntariado', 'Investigación']),
                
                'desde' => $faker->dateTimeBetween($startDate = '-10 years', $endDate = 'now', $timezone = null)->format('Y-m-d'),
                'hasta' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+10 years', $timezone = null)->format('Y-m-d'),
                
                'descripcion' => $faker->text,

                'director_id' => random_int(1, 5),
                'codirector_id' => random_int(1, 5),
            ]);

            $p = Proyecto::find($i);

            /*
            $p -> participantes() -> attach(random_int(1, 4), ['funcion_desempeniada' => Arr::random(['Becario', 'Estudiante', 'Investigador', 'Tecnico']), 'inicio_participacion' => $faker->date, 'fin_participacion' => $faker->date]);
            $p -> participantes() -> attach(random_int(5, 8), ['funcion_desempeniada' => Arr::random(['Becario', 'Estudiante', 'Investigador', 'Tecnico']), 'inicio_participacion' => $faker->date, 'fin_participacion' => $faker->date]);
            $p -> participantes() -> attach(random_int(9, 12), ['funcion_desempeniada' => Arr::random(['Becario', 'Estudiante', 'Investigador', 'Tecnico']), 'inicio_participacion' => $faker->date, 'fin_participacion' => $faker->date]);

            $p -> entidadesParticipantes() -> attach(1,
            [
                'ejecuta'   => Arr::random([0, 1]),
                'evalua'    => Arr::random([0, 1]),
                'adopta'    => Arr::random([0, 1]),
                'demanda'   => Arr::random([0, 1]),
                'promueve'  => Arr::random([0, 1]),
                'financia'  => random_int(0, 50),
            ]);

            $p -> entidadesParticipantes() -> attach(2,
            [
                'ejecuta'   => Arr::random([0, 1]),
                'evalua'    => Arr::random([0, 1]),
                'adopta'    => Arr::random([0, 1]),
                'demanda'   => Arr::random([0, 1]),
                'promueve'  => Arr::random([0, 1]),
                'financia'  => random_int(0, 50),
            ]);
            */
            $p->save();
        }
    }
}
