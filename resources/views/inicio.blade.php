<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Gestiona - Inicio</title>
		<link rel="stylesheet" href="css/app.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<h1 class="text-center inicioTitle">GESTIONA</h1>
				<br>
				<h3 class="text-center">
				Con <b>GESTIONA</b> podrás realizar la gestión del hogar fácilmente. Tendrás el control tanto de los ingresos y gastos, y así ver cuanto eres capaz de ahorrar mes a mes.
				</h3>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="inicioContenido">
						<h3 class="text-center">Comienza tu gestión</h3>
						<form action="login" method="post">
							{{ csrf_field() }}
							<div class="form-group">
								<input type="email" name="inicioEmail" class="form-control" placeholder="Email">
							</div>
							<div class="form-group">
								<input type="password" name="inicioPassword" class="form-control" placeholder="Password">
							</div>
							<input type="submit" name="enviar" value="Iniciar Sesión" class="btn btn-block btn-info">
						</form>
						<br>
						<a href="" class="text-danger">Olvidaste la contraseña?</a>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="inicioContenido">
						<h3 class="text-center">Crea tu cuenta</h3>
						<form action="registro" method="post">
							{{ csrf_field() }}
							<div class="form-group">
								<input type="text" name="registroNombre" class="form-control" value="" placeholder="Nombre">
							</div>
							<div class="form-group">
								<input type="text" name="registroApellidos" class="form-control" value="" placeholder="Apellidos">
							</div>
							<div class="form-group">
								<input type="email" name="registroEmail" class="form-control" placeholder="Email">
							</div>
							<div class="form-group">
								<input type="password" name="registroPassword" class="form-control" placeholder="Password">
							</div>
							<div class="form-group">
								<input type="password" name="registroRepassword" class="form-control" placeholder="Repite Password">
							</div>
							<input type="submit" name="crear" value="Crear Cuenta" class="btn btn-block btn-info">
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>