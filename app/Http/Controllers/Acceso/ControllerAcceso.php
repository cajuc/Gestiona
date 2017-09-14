<?php

namespace App\Http\Controllers\Acceso;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;
use Mail;

class ControllerAcceso extends Controller
{

	/*
		En esta función se lleva acabo la autenticación del usuario con sus credenciales
		Si las credenciales no son correctas se devuelve un mensaje de error
	*/
    public function login(Request $request){
    	if (Auth::attempt([
    			'email' => $request->input('inicioEmail'), 
    			'password' => $request->input('inicioPassword'), 
    			'active' => 1])) {

    		return redirect()->action('ControllerMain@inicio');
    	}else{
    		return redirect('/')->with([
    			'message' => 'El email/contraseña no son correctos o su cuenta aún no ha sido activada',
    			'class' => 'alert-danger'
    		]);
    	}
    }

    /*
		Én esta función se lleva acabo la validación del nuevo usuario y se envía el email para realizar
		la confirmación de la cuenta
    */
    public function registro(Request $request){
    	// Si el usuario ya existe redireccionará a la página de inicio con un mensaje de error
    	$this->validate($request, [
    		'registroEmail' => 'unique:users,email'
    	]);

    	// Se crea el nuevo usuario
    	$user = new User;

    	$data['name'] = $user->name = $request->input('registroNombre');
    	$data['surnames'] = $user->surnames = $request->input('registroApellidos');
    	$data['email'] = $user->email = $request->input('registroEmail');
    	$user->password = bcrypt($request->input('registroPassword'));
    	$data['confirm_token'] = $user->confirm_token = str_random(100);
    	$user->save();

    	// Se crea un registro en la tabla para resetear el password del nuevo usuario
    	DB::table('password_resets')->insert([
    		'email' => $request->input('registroEmail'),
    		'token' => str_random(100)
    	]);

    	// Se envía el email de confirmación
    	Mail::send('mails.register', ['data' => $data], function($mail) use($data){
    		$mail->subject('Confirma tu cuenta');
    		$mail->to($data['email'], $data['name']);
    	});

    	return redirect('/')->with('message', 'Se ha enviado un email de confirmación');
    }

    /*
		En esta función se verifica que el usuario ha confirmado su cuenta desde el email
    */
    public function confirmRegister($email, $confirm_token){
    	$the_user = User::select()->where('email', $email)
    		->where('confirm_token',$confirm_token)->first();

    	if (count($the_user) > 0) {
    		$the_user['actived'] = 1;
    		$the_user['confirm_token'] = str_random(100);
    		$the_user->save();

    		return redirect('/')->with('message', 'Enhorabuena ' . $the_user['name'] . ' ya puede iniciar sesión');
    	}else{
    		return redirect('/');
    	}
    }

    /*
		Se retorna la vista para introducir el email donde se enviará el enlace para resetear el password
    */
	public function forgetPassword(Request $request){
		return view('reset');
	}

	/*
		En esta función se válida el email introducido y se envía un correo con la dirección para resetear la contraseña
	*/
	public function resetPassword(Request $request){
		$this->validate($request, [
    		'resetEmail' => 'required|exists:password_resets,email'
    	]);

    	$user = DB::table('password_resets')->where('email',$request->input('resetEmail'))->first();

    	$data['email'] = $request->input('resetEmail');
    	$data['token'] = $user->token;

    	// Se envía el email para restablecer contraseña
    	Mail::send('mails.resetPassword', ['data' => $data], function($mail) use($data){
    		$mail->subject('Restablecer contraseña');
    		$mail->to($data['email']);
    	});

    	return redirect('forgetPassword')->with('message', 'Se ha enviado el correo para restablecer contraseña');
	}

	/*
		En esta función se introduce la nueva contraseña del usuario
	*/

	public function newPassword($email, $token){
		$user = DB::table('password_resets')
			->where([
				'email' => $email,
				'token' => $token
			])->first();

		if (count($user) > 0) {
			return view('newPassword', ['email' => $email]);
		}else{
			return redirect('/');
		}
	}

	/*
		En esta función se retorna a la página de acceso mostrando un mensaje de que
		la contraseña se ha modificado con exito
	*/
	public function passwordChanged(Request $request){
		$user = User::where('email', $request->input('userEmail'))->first();

		// Se actualiza la contraseña
		$user->password = bcrypt($request->newPassword);
		$user->save();

		// Se modifica el token de la tabla password_resets
		DB::table('password_resets')
			->where('email', $request->input('userEmail'))
			->update(['token' => str_random(100)]);

		return redirect('/')->with([
			'message' => 'Se ha restablecido la contraseña',
			'class' => 'alert-success'
		]);
	}
}
