<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Restablecer contraseña</title>
	<link rel="stylesheet" href="css/app.css">
</head>
<body>
	<div class="container">
		<h1 class="text-center">Introduce el email de usuario para restablecer la contraseña</h1>

		@if($errors->any())
			<div class="alert alert-info">
				<ul>
					@foreach($errors->all() as $error)
						<li style="list-style-type: none" class="text-center">{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="col-lg-4 col-lg-offset-4">
			<form action="resetPassword" method="post">
				{{ csrf_field() }}
				<div class="form-group">
					<input type="email" class="form-control" name="resetEmail" placeholder="Introduce email">
				</div>
				<input type="submit" name="reset" value="Restablecer Contraseña" class="btn btn-block btn-info">
			</form>
		</div>

		@if(Session::get('message'))
			<div class="alert alert-success text-center col-lg-offset-3 col-lg-6" style="margin-top: 50px">{{ Session::get('message') }}</div>
		@endif
	</div>
</body>
</html>