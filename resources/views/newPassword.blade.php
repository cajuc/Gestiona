<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Nueva contraseña</title>
	<link rel="stylesheet" href="{{ url('/') }}/css/app.css">
</head>
<body>
	<div class="container">
		<h1 class="text-center">Introduce la nueva contraseña</h1>

		<div class="col-lg-4 col-lg-offset-4">
			<form action="/newPassword" method="post">
				{{ csrf_field() }}
				<input type="hidden" name="userEmail" value="{{ $email }}">
				<div class="form-group">
					<input type="password" class="form-control" name="newPassword" placeholder="Contraseña">
					<span id="resetPwError" class="text-danger"></span>
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="newRePassword" placeholder="Repetir contraseña">
				</div>
				<input type="submit" name="reset" value="Restablecer Contraseña" class="btn btn-block btn-info">
				<span id="formError" class="text-danger" hidden>Debes rellenar correctamente todos los campos</span>
			</form>
		</div>
	</div>

	<script src="{{ url('/') }}/js/app.js"></script>
	<script src="{{ url('/') }}/js/script.js"></script>
</body>
</html>