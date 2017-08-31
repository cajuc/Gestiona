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
});

Route::post('registro', 'Acceso\ControllerAcceso@registro');
Route::get('auth/confirm/email/{email}/confirm_token/{confirm_token}','Acceso\ControllerAcceso@confirmRegister');
Route::post('login', 'Acceso\ControllerAcceso@login');
Route::get('forgetPassword', 'Acceso\ControllerAcceso@forgetPassword');
Route::post('resetPassword', 'Acceso\ControllerAcceso@resetPassword');
Route::get('reset_password/email/{email}/token/{token}', 'Acceso\ControllerAcceso@newPassword');
Route::post('newPassword', 'Acceso\ControllerAcceso@passwordChanged');