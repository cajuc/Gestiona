@extends('master')
@section('title', $title)
@section('content-body')
<div class="row">
	<div class="col-lg-12">
		<div class="row father">
			<div class="col-xs-12 visible-xs text-center">
				<a href="{{ url('/ingresos') }}">
					<span class="glyphicon glyphicon-euro" style="font-size: 2em; color: green;"></span>
				</a>
			</div>
			<div class="col-lg-9 col-sm-9 description">
				<p class="hidden-xs text-justify">
					En el apartado de <b>Ingresos</b> podrás ver un historial de los ingresos realizados, los cuales
					se ordenarán por orden cronológico descendente. Se permitirá editar y/o borrar cada uno de ellos, al igual que crear nuevos <b>Ingresos</b>. También se dispone de una gráfica con el que se puede observar la evolución de los ingresos de los diferentes años registrados.
				</p>
				<p class="visible-xs text-center">
					Realiza tus <b>Ingresos</b> y observa su evolución a lo largo del tiempo.
				</p>
			</div>
			<div class="col-lg-3 col-sm-3 text-center child-right hidden-xs">
				<a href="{{ url('/ingresos') }}">
					<span class="glyphicon glyphicon-euro" style="font-size: 4em; color: green;"></span>
				</a>
			</div>
		</div>

		<div class="row father">
			<div class="col-xs-12 visible-xs text-center">
				<a href="{{ url('/gastos') }}">
					<span class="glyphicon glyphicon-remove" style="font-size: 2em; color: red;"></span>
				</a>
			</div>
			<div class="col-lg-3 col-sm-3 text-center child-left hidden-xs">
				<a href="{{ url('/gastos') }}">
					<span class="glyphicon glyphicon-remove" style="font-size: 4em; color: red;"></span>
				</a>
			</div>
			<div class="col-lg-9 col-sm-9 description-right">
				<p class="hidden-xs text-justify">
					Visualiza los <b>Gastos</b> que se han ido produciendo a lo largo del tiempo los cuales se ordenarán al igual que lo hacen los <b>Ingresos</b>. Se podrá modificar y/o borrar cualquier <b>Gasto</b>, así como crear nuevos <b>Gastos</b>. Estos se clasificarán como gasto: <i>Fijo, Variable, Fijo-Variable</i>. Se dispone también de una gráfica donde ver la evolución de los <b>Gastos</b> de cada año, al igual que una gráfica donde se detalla con más precisión el porcentaje de cada <b>Gasto</b> de cada concepto (luz, agua, ..) en cada año. 
				</p>
				<p class="visible-xs text-center">
					Añade tus <b>Gastos</b> y comprueba en que conceptos inviertes más dinero
				</p>
			</div>
		</div>

		<div class="row father">
			<div class="col-xs-12 visible-xs text-center">
				<a href="{{ url('/ahorros') }}">
					<span class="glyphicon glyphicon-piggy-bank" style="font-size: 2em; color: pink;"></span>
				</a>
			</div>
			<div class="col-lg-9 col-sm-9 description">
				<p class="hidden-xs text-justify">
					Comprueba como han ido evolucionando los <b>Ahorros</b> mes a mes de cada año. De esta forma podrás observar como progresa la relación entre los <b>Gastos</b> e <b>Ingresos</b> que se producen y gestionarlos de la forma más adecuada.
				</p>
				<p class="visible-xs text-center">
					Observa en la gráfica disponible como progesan tus <b>Ahorros</b>
				</p>
			</div>
			<div class="col-lg-3 col-sm-3 text-center child-right hidden-xs">
				<a href="{{ url('/ahorros') }}">
					<span class="glyphicon glyphicon-piggy-bank" style="font-size: 4em; color: pink;"></span>
				</a>
			</div>
		</div>

		<div class="row father">
			<div class="col-xs-12 visible-xs text-center">
				<a href="{{ url('/ajustes') }}">
					<span class="glyphicon glyphicon-cog" style="font-size: 2em; color: black;"></span>
				</a>
			</div>
			<div class="col-lg-3 col-sm-3 text-center child-left hidden-xs">
				<a href="{{ url('/ajustes') }}">
					<span class="glyphicon glyphicon-cog" style="font-size: 4em; color: black;"></span>
				</a>
			</div>
			<div class="col-lg-9 col-sm-9 description-right">
				<p class="hidden-xs text-justify">
					En el apartado de <b>Ajustes</b> podrás realizar algunos cambios como modificar el Nombre, Apellidos, ... con los que te registraste, así como los <b>fondos</b> disponibles a partir de los cuales se calculará la evolución de tu economía personal.
				</p>
				<p class="visible-xs text-center">
					Configura tus datos de perfil
				</p>
			</div>
		</div>
	</div>
</div>
@endsection