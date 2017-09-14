<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Recursos;
use App\Ingreso;

class ControllerMain extends Controller
{
    /*
		Se restringe el acceso a la Aplicación a aquellos que no hayan iniciado sesión
    */
	public function __construct(){
		$this->middleware('auth');
	}

	/*
		Controla el acceso a la aplicación
	*/
	public function inicio(){
		return view('inicio', ['title' => 'Inicio']);
	}

    /*
		En esta función se cierra la sesión del usuario
    */
	public function logout(){
		Auth::logout();

		return redirect('/');
	}

	/*
		Maneja la petición a 'Ingresos' y devuelve los datos necesarios para esta vista
	*/
	public function ingresos(){
		// Se obtiene los fondos del usuario
		$fondos = Auth::user()->fondos;

		// Se obtienen todos los ingresos del usuario
		$ingresos = Recursos::obtenerIngresos();

		return view('ingresos', [
				'title' => 'Ingresos',
				'fondos' => $fondos,
				'ingresos' => $ingresos
			]);
	}

	/*
		Maneja la petición de borrar un ingreso
	*/
	public function borrarIngreso($id){
		Ingreso::destroy($id);

		return redirect()->back()->with('message', 'Se ha borrado correctamente.');
	}
}
