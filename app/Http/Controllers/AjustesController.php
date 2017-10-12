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

		return back()->with('message', 'Los cambios se han realizado con exito!!');
	}

	public function cambiarImage(Request $request){
		$this->validate($request, [
			'image' => [
				'required',
				'image',  
				'mimetypes:image/jpeg,image/png'
			]
		]);

		$user = Auth::user();

		
		$extension = $request->image->extension();
		$nombreImage = $user->email.'-perfil.'.$extension;

		// Se almacena la imagen en el servidor
		$path = $request->image->storeAs('images', $nombreImage);
// dd($path);
		if ($request->file('image')->isValid()) {

			// Se actualiza el campo image del usuario con $nombreImage
			$user->image = $nombreImage;
			$user->save();


			return back()->with('message', 'Se ha modificado la imagen de perfil con exito!!');
		}

		return back()->with('message', 'Se ha producido un error al actualizar la imagen de perfil');
	}
}
