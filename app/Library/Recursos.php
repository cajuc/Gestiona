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
            ->orderBy(DB::raw("MONTH(fecha)"), 'asc')
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
    	$tipos = \DB::select(\DB::raw("show columns from gastos like 'tipo'"))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $tipos, $matches);
        $enum = array();
        
        foreach( explode(',', $matches[1]) as $value )
        {
            $v = trim( $value, "'" );
            array_push($enum, $v);
        }

        return $enum;
    }

    public static function obtenerGastosChart($year)
    {
        $user = Auth::user();

        // Se obtienen los gastos del usuario
        $gastos = $user->gastos()
            ->select(DB::raw("SUM(cantidad) as cantidad, MONTH(fecha) as month"), 'tipo')
            ->where(DB::raw("YEAR(fecha)"), $year)
            ->groupBy(DB::raw("MONTH(fecha)"), 'tipo')
            ->orderBy(DB::raw('MONTH(fecha)'), 'asc')
            ->orderBy('tipo')
            ->get();

        return $gastos;
    }

    public static function obtenerGastosTipo($year, $tipo)
    {
        $user = Auth::user();

        // Se obtienen los gastos del usuario agrupados por año y concepto
        $gastos = $user->gastos()
            ->select(DB::raw('SUM(cantidad) as  cantidad'), 'concepto')
            ->where([
                [DB::raw('YEAR(fecha)'), $year],
                ['tipo', $tipo]
            ])
            ->groupBy(DB::raw('YEAR(fecha)'), 'concepto')
            ->orderBy('cantidad', 'desc')
            ->get();

        return $gastos;
    }

    public static function yearsAhorros()
    {
        $user = Auth::user();                 

        $years = DB::table('users')
                    ->join('ingresos', 'users.id', '=', 'ingresos.user_id')
                    ->join('gastos', 'users.id', '=', 'gastos.user_id')
                    ->select(DB::raw("YEAR(ingresos.fecha) as year"))
                    ->distinct(DB::raw("YEAR(ingresos.fecha)"))
                    ->where('users.id', $user->id)
                    ->whereColumn(DB::raw("YEAR(ingresos.fecha)"), DB::raw("YEAR(gastos.fecha)"))
                    ->orderBy(DB::raw("YEAR(ingresos.fecha)"), 'desc')
                    ->get();

        return $years;
    }

    public static function obtenerAhorros($year)
    {
        $user    = Auth::user();
        $ahorros = [];
        $dif     = 0;
        
        // Se obtienen los ingresos(cantidad, mes) del año $year agrupados en meses
        $ingresos = $user->ingresos()
            ->select(DB::raw("SUM(cantidad) as cantidad, MONTH(fecha) as month"))
            ->where(DB::raw("YEAR(fecha)"), $year)
            ->groupBy(DB::raw("MONTH(fecha)"))
            ->orderBy(DB::raw("MONTH(fecha)"), 'asc')
            ->get();
        
        // Se obtienen los gastos(cantidad, mes) del año $year agrupados en meses 
        $gastos   = $user->gastos()
            ->select(DB::raw("SUM(cantidad) as cantidad, MONTH(fecha) as month"))
            ->where(DB::raw("YEAR(fecha)"), $year)
            ->groupBy(DB::raw("MONTH(fecha)"))
            ->orderBy(DB::raw("MONTH(fecha)"), 'asc')
            ->get();

        // Se obtiene la diferencia de la cantidad de los ingresos y gastos que coincidan cada mes
        // y se añade al array $ahorros
        foreach ($ingresos as $key => $ingreso) {
            $dif = 0;
            $ok  = false;

            foreach ($gastos as $key => $gasto) {
                if ($gasto->month == $ingreso->month) {
                    $dif = $ingreso->cantidad - $gasto->cantidad;

                    array_push($ahorros, [
                        'month'    => $ingreso->month,
                        'cantidad' => $dif
                    ]);

                    $ok = true;
                    break;
                }
            }

            // Se añade un nuevo item a $ahorros con la cantidad y mes actual del ingreso actual
            // el cual no coincide con ningún mes de los gastos obtenidos
            if (!$ok) {
                array_push($ahorros, [
                    'month' => $ingreso->month,
                    'cantidad' => $ingreso->cantidad
                ]);
            }
        }

        foreach ($gastos as $key => $gasto) {
            $ok= false;

            foreach ($ingresos as $key => $ingreso) {
                if ($ingreso->month == $gasto->month) {
                    $ok = true;
                    break;
                }    
            }

            // Se añade un nuevo item a $ahorros con la cantidad y mes actual del gsato actual
            // el cual no coincide con ningún mes de los ingresos obtenidos
            if (!$ok) {
                array_push($ahorros, [
                    'month' => $gasto->month,
                    'cantidad' => -$gasto->cantidad
                ]);
            }
        }

        // Se ordena el array por el mes de forma ascendente
        $ahorros = array_values(array_sort($ahorros, function($value){
            return $value['month'];
        }));


        return $ahorros;
    }
}