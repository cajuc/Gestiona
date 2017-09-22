<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Recursos;
use App\Ingreso;
use App\Gasto;
use Validator;

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
		// Se obtienen todos los ingresos del usuario
		$ingresos = Recursos::obtenerIngresos();

		// Se obtienen los diferentes conceptos de ingresos del usuario
		$conceptos = Recursos::obtenerConceptos('ingresos');

		// Se obtienen los años en los que existen ingresos
		$years = Recursos::obtenerYears('ingresos');

		return view('ingresos', [
				'title' => 'Ingresos',
				'ingresos' => $ingresos,
				'conceptos' => $conceptos,
				'years' => $years
			]);
	}

	/*
		Maneja la petición de borrar un ingreso
	*/
	public function borrarIngreso($id){
		// Se actualiza los fondos del usuario
		$user = Auth::user();
		$ingreso = Ingreso::find($id);
		$user->fondos = $user->fondos - $ingreso->cantidad;
		$user->save();

		// Se elimina el ingreso
		$ingreso->delete();

		return redirect()->back()->with('message', 'Se ha borrado correctamente.');
	}

	/*
		Maneja la petición de editar un ingreso
	*/
	public function editarIngreso(Request $request, $id){
		$validator = Validator::make($request->all(), [
			'concepto' 		=> 'required|max:30',
			'fecha'			=> 'required|date_format:Y-m-d',
			'cantidad'		=> 'required|numeric'
		]);

		// En caso de que los campos concepto y fecha introducidos existan en algún ingreso se informará del error
		$validator->sometimes(['concepto', 'fecha'], 'unique:ingresos', function($input) use ($id){
			$ingresos = Ingreso::where([
				['concepto', $input->concepto],
				['fecha', $input->fecha],
				['id', '<>', $id]
			])->get();

			return count($ingresos);
		});

		// En caso de error se devolverán los errores producidos
		if ($validator->fails()) {
			return redirect()->back()->with([
				'class' => 'alert-danger',
				'message' => 'Ya existe un ingreso con el concepto y fecha introducidos.'
			]);
		}

		$ingreso = Ingreso::find($id);
		
		// Se actualiza los fondos del usuario
		if ($ingreso->cantidad > $request->cantidad || $ingreso->cantidad < $request->cantidad) {
			$diferencia = ($ingreso->cantidad < $request->cantidad) ? $request->cantidad - $ingreso->cantidad : $ingreso->cantidad - $request->cantidad;
			$user = Auth::user();
			$user->fondos = ($ingreso->cantidad < $request->cantidad) ? $user->fondos + $diferencia : $user->fondos - $diferencia;
			$user->save();
		}

		// Se actualiza el ingreso con los valores introducidos
		$ingreso->concepto = $request->concepto;
		$ingreso->fecha = $request->fecha;
		$ingreso->cantidad = $request->cantidad;
		$ingreso->comentario = $request->comentario;

		// Se guardan los cammbios
		$ingreso->save();


		return redirect()->back()->with('message', 'Se ha actualizado correctamente el ingreso.');
	}

	/*
		Maneja la petición de crear un nuevo ingreso
	*/
	public function crearIngreso(Request $request){
		$validator = Validator::make($request->all(), [
			'concepto' 		=> 'required|max:30',
			'fecha'			=> 'required|date_format:Y-m-d',
			'cantidad'		=> 'required|numeric'
		]);

		// En caso de que los campos concepto y fecha introducidos existan en algún ingreso se informará del error
		$validator->sometimes(['concepto', 'fecha'], 'unique:ingresos', function($input){
			$ingresos = Ingreso::where([
				['concepto', $input->concepto],
				['fecha', $input->fecha]
			])->get();

			return count($ingresos);
		});

		// En caso de error se devolverán los errores producidos
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator);
		}

		// Se crea una instancia de Ingreso
		$ingreso = new Ingreso;

		// Informamos la instancia         
		$ingreso->concepto 		= $request->concepto;
		$ingreso->fecha 		= $request->fecha;
		$ingreso->cantidad		= $request->cantidad;
		$ingreso->comentario	= $request->comentario;
		$ingreso->user_id 		= Auth::user()->id;

		// Guardamos la instancia
		$ingreso->save();

		// Se actualiza los fondos del usuario
		$user = Auth::user();
		$user->fondos = $user->fondos + $ingreso->cantidad;
		$user->save();

		return redirect()->back()->with('message', 'Se ha creado un nuevo ingreso.');
	}

	/*
		Se obtienen los diferentes conceptos existentes y se devuelven en formato JSON
	*/
	public function obtenerConceptos($table, $tipo = NULL){
		$conceptos = is_null($tipo) ? Recursos::obtenerConceptos($table) : Recursos::obtenerConceptos($table, $tipo);
		
		return response()->json($conceptos);
	}

	/*
		Se obtienen los ingresos del usuario y se devuelven en formato JSON
	*/
	public function obtenerIngresos(Request $request, $year){
		$ingresos = Recursos::obtenerIngresosChart($year);

		return response()->json($ingresos);
	}

	/*
		Maneja la petición a 'Gastos' y devuelve los datos necesarios a esta vista
	*/
	public function gastos()
	{
		// Se obtienen los gastos del usuario
		$gastos = Recursos::obtenerGastos();

		// Se obtienen los diferentes conceptos de gastos del usuario
		// $conceptos = Recursos::obtenerConceptos(\Request::path());

		// Se obtienen los diferentes tipos de gastos del usuario
		$tipos = Recursos::obtenerTipos();

		// Se obtienen los diferentes años en los que existen ingresos
		$years = Recursos::obtenerYears('gastos');

		return view('gastos', [
			'title' => 'Gastos',
			'gastos' => $gastos,
			'years' => $years,
			'tipos' => $tipos
		]);
	}

	/*
		Maneja la petición de borrar un gasto
	*/
	public function borrarGasto($id){
		// Se actualiza los fondos del usuario
		$user = Auth::user();
		$gasto = Gasto::find($id);
		$user->fondos = $user->fondos + $gasto->cantidad;
		$user->save();

		// Se elimina el ingreso
		$gasto->delete();

		return redirect()->back()->with('message', 'Se ha borrado correctamente.');
	}

	/*
		Maneja la petición de editar un ingreso
	*/
	public function editarGasto(Request $request, $id){
		$validator = Validator::make($request->all(), [
			'tipo'			=> 'required',
			'concepto' 		=> [
				'required',
				'max:30',
				Rule::unique('gastos')->where(function($query) use ($request){
					$query
						->where([
							['tipo', $request->tipo],
							['concepto', $request->concepto],
							['id', '<>', $request->id]
						]);
				}),
			],
			'fecha'			=> 'required|date_format:Y-m-d',
			'cantidad'		=> 'required|numeric'
		]);

		// En caso de que los campos concepto y fecha introducidos existan en algún ingreso se informará del error
		$validator->sometimes(['concepto', 'fecha', 'tipo'], 'unique:gastos', function($input) use ($id){
			$gastos = Gasto::where([
				['concepto', $input->concepto],
				['fecha', $input->fecha],
				['tipo', $input->tipo],
				['id', '<>', $id]
			])->get();

			return count($gastos);
		});

		// En caso de error se devolverán los errores producidos
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator);
		}

		$gasto = gasto::find($id);
		
		// Se actualiza los fondos del usuario
		if ($gasto->cantidad > $request->cantidad || $gasto->cantidad < $request->cantidad) {
			$diferencia = ($gasto->cantidad < $request->cantidad) ? $request->cantidad - $gasto->cantidad : $gasto->cantidad - $request->cantidad;
			$user = Auth::user();
			$user->fondos = ($gasto->cantidad < $request->cantidad) ? $user->fondos - $diferencia : $user->fondos + $diferencia;
			$user->save();
		}

		// Se actualiza el gasto con los valores introducidos
		$gasto->concepto = $request->concepto;
		$gasto->tipo = $request->tipo;
		$gasto->fecha = $request->fecha;
		$gasto->cantidad = $request->cantidad;
		$gasto->comentario = $request->comentario;

		// Se guardan los cammbios
		$gasto->save();


		return redirect()->back()->with('message', 'Se ha actualizado correctamente el gasto.');
	}

	/*
		Maneja la petición de crear un nuevo ingreso
	*/
	public function crearGasto(Request $request){
		$validator = Validator::make($request->all(), [
			'tipo'			=> 'required',
			'concepto' 		=> 'required|max:30',
			'fecha'			=> 'required|date_format:Y-m-d',
			'cantidad'		=> 'required|numeric'
		]);

		// En caso de que los campos concepto y fecha introducidos existan en algún ingreso se informará del error
		$validator->sometimes(['concepto', 'fecha', 'tipo'], 'unique:gastos', function($input){
			$gastos = Gasto::where([
				['concepto', $input->concepto],
				['fecha', $input->fecha],
				['tipo', $input->tipo]
			])->get();

			return count($gastos);
		});

		// En caso de error se devolverán los errores producidos
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator);
		}

		// Se crea una instancia de Ingreso
		$gasto = new Gasto;

		// Informamos la instancia         
		$gasto->concepto = $request->concepto;
		$gasto->tipo = $request->tipo;
		$gasto->fecha = $request->fecha;
		$gasto->cantidad = $request->cantidad;
		$gasto->comentario = $request->comentario;
		$gasto->user_id = Auth::user()->id;

		// Guardamos la instancia
		$gasto->save();

		// Se actualiza los fondos del usuario
		$user = Auth::user();
		$user->fondos = $user->fondos + $gasto->cantidad;
		$user->save();

		return redirect()->back()->with('message', 'Se ha creado un nuevo gasto.');
	}
}
