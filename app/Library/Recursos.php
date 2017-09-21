<?php
use App\User;
use Illuminate\Support\Facades\DB;

class Recursos
{
    public static function obtenerIngresos(){
    	$user = Auth::user();

    	// Se obtienen los ingresos y se indican que van a ser paginados
    	$ingresos = $user->ingresos()->orderBy('fecha', 'desc')->paginate(5);

    	return $ingresos;
    }

    public static function obtenerConceptos(){
    	$user = Auth::user();

    	// Obtener todos los conceptos del usuario
    	$conceptos = $user->ingresos()->select('concepto')->distinct()->get();

    	return $conceptos;
    }

    public static function obtenerIngresosChart($year)
    {
    	$user = Auth::user();

    	// Se obtienen los ingresos del usuario
    	$ingresos = $user->ingresos()
    		->select(DB::raw("SUM(cantidad) as cantidad, MONTH(fecha) as month, YEAR(fecha) as year"))
    		->where(DB::raw("YEAR(fecha)"), $year)
    		->groupBy(DB::raw("MONTH(fecha), YEAR(fecha)"))
    		->get();

    	return $ingresos;
    }

    public static function obtenerYears()
    {
    	$user = Auth::user();

    	// Se obtienen los diferentes años en los que existen ingresos
    	$years = $user->ingresos()
    		->select(DB::raw("YEAR(fecha) as year"))
    		->distinct(DB::raw("YEAR(fecha)"))
    		->orderBy(DB::raw("YEAR(fecha)"), 'desc')
    		->get();

    	return $years;
    }
}