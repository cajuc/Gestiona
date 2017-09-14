<?php

use Illuminate\Database\Seeder;

class IngresosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Ingreso::class, 10)->create();
    }
}
