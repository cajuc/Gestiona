<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Recursos;

class AhorrosController extends Controller
{
    // Maneja la petición de acceso al apartado Ahorros
    public function index()
    {
    	
    	$years = Recursos::yearsAhorros();

    	return view('ahorros', [
			'title'   => 'Ahorros',
			'years' => $years
    	]);	
    }

    // Maneja la petición para obtener los 'ahorros' del usuario
    public function obtenerAhorros($year)
    {
    	$ahorros = Recursos::obtenerAhorros($year);

    	return response()->json($ahorros);
    }
}
