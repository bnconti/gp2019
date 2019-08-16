<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonasSeeder extends Seeder
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
            DB::table('persona')->insert([
                'apellido' => $faker->lastName,
                'nombre' => $faker->firstName,
                'cuit_cuil' => '20' . strval(random_int(10000000, 40000000)) . '7',
                'usuarios_id' => $i,
            ]);
        }
    }
}
