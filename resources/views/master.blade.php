<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>Gestiona - @yield('title')</title>
		<link rel="stylesheet" href="css/app.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/jquery-ui.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-lg-6 pull-left">
					<h1 class="title"><a href="{{ url('inicio') }}" style="text-decoration: none;color: #636B6F">GESTIONA</a></h1>
				</div>
				<div class="col-lg-5">
					<h2 class="text-right">Bienvenido <b>{{ $user->name }}</b></h2>
					<span class="pull-right"><b>{{ $user->fondos }}€</b> disponibles</span>
				</div>
				<div class="col-lg-1 logout">
					<form action="logout" method="post">
						{{ csrf_field() }}
						<input type="submit" name="salir" value="Salir" class="form-control btn btn-danger">
					</form>
				</div>
			</div>
			<br>
			<div class="menu-nav">
				<nav class="nav navbar-default">
					<div class="container-fluid">
						<div class="navbar-header">
							<button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
								<span class="sr-only">Toggle Navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand">
								<img src="images/logo.png" alt="gestiona" class="brand-image">
							</a>
						</div>
						<div class="collapse navbar-collapse" id="navbar-collapse">
							<ul class="nav navbar-nav">
								<li class="{{ Request::is('inicio') ? 'active' : '' }}">
									<a href="{{ url('inicio') }}"><span style="color:orange" class="glyphicon glyphicon-home"></span> Inicio</a>
								</li>
								<li class="{{ Request::is('ingresos') ? 'active' : '' }}">
									<a href="{{ url('ingresos') }}"><span style="color:green" class="glyphicon glyphicon-euro" aria-hidden="true"></span> Ingresos</a>
								</li>
								<li class="{{ Request::is('gastos') ? 'active' : '' }}">
									<a href="{{ url('gastos') }}"><span style="color:red" class="glyphicon glyphicon-remove" aria-hidden="true"></span> Gastos</a>
								</li>
								<li class="{{ Request::is('ahorros') ? 'active' : '' }}">
									<a href="{{ url('ahorros') }}"><span style="color:pink" class="glyphicon glyphicon-piggy-bank"  aria-hidden="true"></span> Ahorros</a>
								</li>
								<li class="{{ Request::is('ajustes') ? 'active' : '' }}">
									<a href="{{ url('ajustes') }}"><span style="color:black" class="glyphicon glyphicon-cog"  aria-hidden="true"></span> Ajustes</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			
			@yield('content-body')
			
		</div>

		<script src="js/app.js"></script>
		<script src="js/jquery-ui.js"></script>
		<script src="js/script.js"></script>
	</body>
</html>