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

    public static function obtenerConceptos($table, $tipo = NULL){
    	$user = Auth::user();
    	
    	switch ($table) {
    		case 'ingresos':
		    	$conceptos = $user->ingresos()->select('concepto')->distinct()->get();

    			break;
    		case 'gastos':
                $conceptos = is_null($tipo) ? 
                    $user->gastos()->select('concepto')->distinct()->get() :
                    $user->gastos()->select('concepto')->distinct()->where('tipo', $tipo)->get();

    			break;
    		default:
    			break;
    	}


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

    public static function obtenerYears($table)
    {
    	$user = Auth::user();

    	// Se obtienen los diferentes años en los que existen ingresos
    	switch ($table) {
    		case 'ingresos':
		    	$years = $user->ingresos()
		    		->select(DB::raw("YEAR(fecha) as year"))
		    		->distinct(DB::raw("YEAR(fecha)"))
		    		->orderBy(DB::raw("YEAR(fecha)"), 'desc')
		    		->get();
    			
    			break;
			case 'gastos':
			    $years = $user->gastos()
		    		->select(DB::raw("YEAR(fecha) as year"))
		    		->distinct(DB::raw("YEAR(fecha)"))
		    		->orderBy(DB::raw("YEAR(fecha)"), 'desc')
		    		->get();
				
				break;    		
    		default:
    			# code...
    			break;
    	}



    	return $years;
    }

    public static function obtenerGastos()
    {
    	$user = Auth::user();

    	// Se obtienen los gastos del usuario
    	$gastos = $user->gastos()->orderBy('fecha', 'desc')->paginate(5);

    	return $gastos;
    }

    public static function obtenerTipos()
    {
    	$user = Auth::user();

    	$tipos = $user->gastos()->select('tipo')->distinct()->get();

        return $tipos;
    }
}