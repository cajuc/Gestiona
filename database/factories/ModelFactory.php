<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
        'name' => 'Carlos',
        'surnames' => 'Jurado Checa',
        'email' => 'bycajuc@gmail.com',
        'password' => bcrypt('bycajuc'),
        'fondos' => 0,
        'active' => 1,
        'confirm_token' => str_random(100),
        'remember_token' => str_random(100)
    ];
});

$factory->define(App\Ingreso::class, function(Faker\Generator $faker){
	$fecha = date('Y-m-d H:i:s');

	return [
		'concepto' => 'nomina',
		'comentario' => $faker->realText($faker->numberBetween(30, 200)),
		'fecha' => $faker->dateTime(),
		'cantidad' => $faker->numberBetween(800, 1100),
		'user_id' => 1
	];
});
