<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Recursos;

class AjustesController extends Controller
{
	public function index()
	{
		$tipos = Recursos::obtenerTipos();

		return view('ajustes', [
			'title' => 'Ajustes',
			'tipos' => $tipos
		]);
	}

	public function store(Request $request)
	{
		$this->validate($request, [
			'name' => [
				'required',
				'regex:/^[A-Za-z]{3,}(\s[A-Za-z]{3,})?/',
				'min:3', 
				'max:30'
			],
			'surnames'  => [
				'required',
				'regex:/^[A-Za-z]{3,}(\s[A-Za-z]{3,})?/',
				'min:3',
			],
			'password'   => [
				'nullable',
				'regex:/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/'
			],
			'rePassword' => [
				'same:password'
			],
			'fondos' => [
				'required',
				'numeric',
				'min:0'
			]
		]);

		$user = Auth::user();

		$user->name     = $request->name;
		$user->surnames = $request->surnames;

		if ($request->password) {
			$user->password = bcrypt($request->password);
		}

		$user->fondos   = $request->fondos;
		$user->save();

		return back()->with('message', 'Los cambios se han realizado con exito!!.');
	}
}
