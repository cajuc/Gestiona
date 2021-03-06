<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Gestiona - Inicio</title>
		<link rel="stylesheet" href="css/app.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<h1 class="text-center title">GESTIONA</h1>
				<br>
				<h3 class="text-center">
				Con <b>GESTIONA</b> podrás realizar la gestión del hogar fácilmente. Tendrás el control tanto de los ingresos y gastos, y así ver cuanto eres capaz de ahorrar mes a mes.
				</h3>
				@if($errors->any())
					<div class="alert alert-info">{{ $errors->first('registroEmail') }}</div>
				@endif

				@if(Session::get('message'))
					@if(Session::get('class'))
						<div class="alert {{ Session::get('class') }} text-center" role="alert">{{ Session::get('message') }}</div>
					@else
						<div class="alert alert-success text-center" role="alert">{{ Session::get('message') }}</div>
					@endif
				@endif
			</div>
			<div class="row main-container">
				<div class="col-lg-4 col-lg-offset-2">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="text-center panel-title">Comienza tu gestión</h3>
						</div>
						<div class="panel-body">
							<form action="{{ url('/login') }}" method="post">
								{{ csrf_field() }}
								<div class="form-group">
									<input type="email" name="inicioEmail" class="form-control" placeholder="Email" value="{{ old('inicioEmail') }}">
								</div>
								<div class="form-group">
									<input type="password" name="inicioPassword" class="form-control" placeholder="Password">
								</div>
								<div class="form-group">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="remember_me"> Recuérdame
										</label>
									</div>
								</div>
								<button type="submit" class="btn btn-block btn-info">Iniciar Sesión</button>
							</form>
							<br>
							<a href="forgetPassword" class="text-danger">Olvidaste la contraseña?</a>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="text-center panel-title">Crea tu cuenta</h3>
						</div>
						<div class="panel-body">
							<form action="{{ url('/registro') }}" method="post">
								{{ csrf_field() }}
								<div class="form-group">
									<input type="text" id="nombre" name="registroNombre" class="form-control" value="" placeholder="Nombre">
									<span id="nombreError" class="text-danger"></span>
								</div>
								<div class="form-group">
									<input type="text" name="registroApellidos" class="form-control" id="apellidos" value="" placeholder="Apellidos">
									<span id="apellidosError" class="text-danger"></span>
								</div>
								<div class="form-group">
									<input type="email" name="registroEmail" class="form-control" placeholder="Email">
									<span id="emailError" class="text-danger"></span>
								</div>
								<div class="form-group">
									<input type="password" name="registroPassword" class="form-control" placeholder="Password">
									<span id="pwError" class="text-danger"></span>
								</div>
								<div class="form-group">
									<input type="password" name="registroRePassword" class="form-control" placeholder="Repite Password">
									<span id="pwReError" class="text-danger"></span>
								</div>
								<input type="submit" name="crear" value="Crear Cuenta" class="btn btn-block btn-info">
								<span id="formError" class="text-danger" hidden>Debes rellenar correctamente todos los campos</span>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="js/app.js"></script>
		<script src="js/script.js"></script>
	</body>
</html>