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
        'email' => 'example@mail.com',
        'password' => bcrypt('password'),
        'fondos' => 0,
        'active' => 1,
        'confirm_token' => str_random(100),
        'remember_token' => str_random(100)
    ];
});

$factory->define(App\Ingreso::class, function(Faker\Generator $faker){
    $cantidad = $faker->numberBetween(800, 1100);
    $concepto = ['nomina', 'acciones', 'pension', 'alquileres'];
    // Se actualiza los fondos del usuario
    $user = App\User::find(1);
    $user->fondos = $user->fondos + $cantidad;
    $user->save();

	return [
		'concepto' => $concepto[rand(0,3)],
		'comentario' => $faker->realText($faker->numberBetween(30, 200)),
		'fecha' => $faker->dateTime(),
		'cantidad' => $cantidad,
		'user_id' => $user->id
	];
});

$factory->define(App\Gasto::class, function(Faker\Generator $faker){
    $cantidad = $faker->numberBetween(20, 250);
    $concepto = ['compra mercadona', 'letra del prestamo', 'luz', 'agua'];
    $tipo = ['fijo', 'variable', 'fijo-variable'];
    // Se actualiza los fondos del usuario
    $user = App\User::find(1);
    $user->fondos = $user->fondos - $cantidad;
    $user->save();

    return [
        'concepto' => $concepto[rand(0,3)],
        'tipo' => $tipo[rand(0,2)],
        'comentario' => $faker->realText($faker->numberBetween(30, 200)),
        'fecha' => $faker->dateTime(),
        'cantidad' => $cantidad,
        'user_id' => $user->id
    ];
});
