<?php

use Illuminate\Database\Seeder;

class EntidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entidad')->insert([
            ['entidad' => 'UNNOBA'],
            ['entidad' => 'UTN'],
            ['entidad' => 'UNLP'],
        ]);
    }
}
