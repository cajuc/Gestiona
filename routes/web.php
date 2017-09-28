<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('acceso');
})->name('acceso');

Route::get('inicio', 'ControllerMain@inicio')->name('inicio');
Route::get('ingresos', 'ControllerMain@ingresos');
Route::delete('ingresos/{id}', 'ControllerMain@borrarIngreso');
Route::put('ingresos/{id}/edit', 'ControllerMain@editarIngreso');
Route::post('ingresos/crear', 'ControllerMain@crearIngreso');
Route::get('obtenerConceptos/{table}', 'ControllerMain@obtenerConceptos');
Route::get('obtenerConceptos/{table}/tipo/{tipo}', 'ControllerMain@obtenerConceptos');
Route::get('ingresosChart/{year}', 'ControllerMain@obtenerIngresos');
Route::get('gastos', 'ControllerMain@gastos');
Route::delete('gastos/{id}', 'ControllerMain@borrarGasto');
Route::put('gastos/{id}/edit', 'ControllerMain@editarGasto');
Route::post('gastos/crear', 'ControllerMain@crearGasto');
Route::get('gastosChart/{year}', 'ControllerMain@obtenerGastos');
Route::get('gastosChartDoughnut/{year}/tipo/{tipo}', 'ControllerMain@obtenerGastosTipo');

Route::post('registro', 'Acceso\ControllerAcceso@registro');
/*
	Route que maneja la petición cuando el usuario quiere salir de la Aplicación
*/
Route::post('logout', 'ControllerMain@logout');

Route::get('auth/confirm/email/{email}/confirm_token/{confirm_token}','Acceso\ControllerAcceso@confirmRegister');
Route::post('login', 'Acceso\ControllerAcceso@login');
Route::get('forgetPassword', 'Acceso\ControllerAcceso@forgetPassword');
Route::post('resetPassword', 'Acceso\ControllerAcceso@resetPassword');
Route::get('reset_password/email/{email}/token/{token}', 'Acceso\ControllerAcceso@newPassword');
Route::post('newPassword', 'Acceso\ControllerAcceso@passwordChanged');