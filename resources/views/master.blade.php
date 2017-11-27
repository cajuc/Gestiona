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
	<link rel="stylesheet" href="css/file-input.css">
</head>
<body>
	<div class="container">
		<div class="row hidden-xs">
			<div class="col-lg-5 col-sm-5">
				<h1 class="title"><a href="{{ url('inicio') }}" style="text-decoration: none;color: #636B6F">GESTIONA</a></h1>
			</div>
			<div class="col-lg-2 col-sm-2 text-center">
				<img src="images/{{ $user->image }}" alt="perfil" class="img-circle user-image">
			</div>
			<div class="col-lg-4 col-sm-5">
				<h2 class="text-right">Bienvenid@ <b>{{ $user->name }}</b></h2>
				<span class="pull-right"><b>{{ $user->fondos }}€</b> disponibles</span>
			</div>

			<div class="col-lg-1 hidden-sm pull-right logout">
				<form action="logout" method="post">
					{{ csrf_field() }}
					<input type="submit" name="salir" value="Salir" class="form-control btn btn-danger">
				</form>
			</div>
		</div>

		<br class="hidden-xs">

		<div class="row">
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
							<a class="navbar-brand" href="{{ url('/inicio') }}">
								<img src="images/logo.png" alt="gestiona" class="brand-image">
							</a>
						</div>
						<div class="collapse navbar-collapse" id="navbar-collapse">
							<div class="perfil visible-xs text-center">
								<img src="images/{{ $user->image }}" class="img-circle pull-left">

								<span class="fondos-xs">{{ $user->fondos }} €</span>

								<div class="pull-right">
									<form action="logout" method="post">
										{{ csrf_field() }}
										<button type="submit" class="btn btn-lg btn-link" title="Salir">
											<span class="glyphicon glyphicon-log-out"></span>
										</button>
									</form>
								</div>
								<div class="clearfix"></div>
							</div>

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
							
							<form class="pull-right visible-sm logout-sm" action="logout" method="post">
								{{ csrf_field() }}
								<button type="submit" class="btn btn-lg" title="Salir" title="Salir">
									<span class="glyphicon glyphicon-log-out"></span>
								</button>
							</form>
						</div>
					</div>
				</nav>
			</div>
		</div>

		<br class="hidden-xs">

		@yield('content-body')

	</div>

	{{-- Carga de Scripts de la Aplicación --}}
	<script src="js/app.js"></script>
	<script src="js/jquery-ui.js"></script>
	<script src="js/script.js"></script>
	@stack('scriptsAjustes')
	@stack('scriptsIngresos')
	@stack('scriptsGastos')
	@stack('scriptsAhorros')
</body>

<footer class="footer container">
	<span>&copy; 2017 - Gestiona</span>
</footer>
</html>