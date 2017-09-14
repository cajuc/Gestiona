<?php
use App\User;

class Recursos
{
    public static function obtenerIngresos(){
    	$user = Auth::user();

    	// Se obtienen los ingresos y se indican que van a ser paginados
    	$ingresos = $user->ingresos()->orderBy('fecha', 'desc')->paginate(5);

    	return $ingresos;
    }
}