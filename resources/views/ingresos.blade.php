@extends('master')
@section('title', $title)
@section('content-body')
<div class="row">
	<div class="col-lg-7">
		<h2 class="title-block">Historial de Ingresos</h2>
		@if (Session::get('message'))
		@if (Session::get('class'))
		<div class="alert text-center {{ Session::get('class') }}" role="alert">
			{{ Session::get('message') }}
		</div>
		@else
		<div class="alert alert-success text-center" role="alert">
			{{ Session::get('message') }}
		</div>
		@endif
		@endif
		@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		@if (count($ingresos))
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Concepto</th>
						<th>Fecha</th>
						<th>Cantidad</th>
						<th>Comentario</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($ingresos as $ingreso)
					<tr>
						<td class="text-capitalize" id="concepto-{{ $ingreso->id }}">{{ $ingreso->concepto }}</td>
						<td id="fecha-{{ $ingreso->id }}">{{ $ingreso->fecha }}</td>
						<td id="cantidad-{{ $ingreso->id }}"><span>{{ $ingreso->cantidad }}</span> €</td>
						<td class="text-justify" id="comentario-{{ $ingreso->id }}">{{ $ingreso->comentario }}</td>
						<td>
							<div class="btn-toolbar" role="toolbar">
								<div class="btn-group">
									<form action="{{ url('ingresos') }}/{{ $ingreso->id }}" method="post">
										{{ method_field('DELETE') }}
										{{ csrf_field() }}
										<button type="submit" class="btn btn-default btn-sm" title="Borrar">
											<span style="color: red" class="glyphicon glyphicon-trash"></span>
										</button>
									</form>
									<button class="btn btn-default btn-sm editForm" type="button" title="Editar" value="{{ $ingreso->id }}">
										<span style="color: blue" class="glyphicon glyphicon-edit"></span>
									</button>
								</div>
							</div>
						</td>
					</tr>
					@endforeach
					<tr class="formEdit" hidden>
						<form action="" method="post">
							{{ method_field('PUT') }}
							{{ csrf_field() }}
							<td>
								<div class="form-group">
									<input type="text" class="form-control" id="formConcepto" name="concepto">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="date" class="form-control datepicker" name="fecha" id="formFecha">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="number" class="form-control" min="0" name="cantidad" id="formCantidad">
								</div>
							</td>
							<td>
								<div class="form-group">
									<textarea name="comentario" class="form-control" rows="2" id="formComentario" maxlength="200"></textarea>
								</div>
							</td>
							<td>
								<div class="btn-toolbar" role="toolbar">
									<div class="btn-group">
										<button class="btn btn-default btn-sm" type="submit" title="Editar">
											<span style="color: blue" class="glyphicon glyphicon-edit"></span>
										</button>
										<span></span>
										<button id="cerrarForm" class="btn btn-default btn-sm" type="button" title="Cerrar">
											<span style="color: red" class="glyphicon glyphicon-remove"></span>
										</button>
									</div>
								</div>
							</td>
						</form>
					</tr>
				</tbody>
			</table>
			<nav class="text-center paginacion" aria-label="mostrar ingresos">
				{{ $ingresos->links() }}
			</nav>
		</div>
		@else
		<div class="alert alert-info">
			No hay registros de ingresos todavía!!
		</div>
		@endif

		<h2 class="title-block">Crear nuevo ingreso</h2>
		<div class="row">
			<form action="{{ url('/') }}/ingresos/crear" method="post">
				{{ csrf_field() }}
				<div class="col-lg-4">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-btn">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Elegir concepto">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									@foreach ($conceptos as $concepto)
									<li><a class="concepto">{{ $concepto->concepto }}</a></li>
									@endforeach
								</ul>
							</div>
							<input id="concepto" type="text" name="concepto" placeholder="Concepto" class="form-control">
						</div>
					</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group">
						<input type="date" name="fecha" value="{{ date("Y-m-d") }}" class="form-control datepicker">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group">
						<input type="number" name="cantidad" min="0" placeholder="Cantidad" class="form-control">
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-lg-12">
					<div class="form-group">
						<textarea name="comentario" placeholder="Comentario" maxlength="200" class="form-control"></textarea>
					</div>
				</div>
				<div class="col-lg-12">
					<input type="submit" name="crearIngreso" value="Nuevo Ingreso" class="btn btn-lg btn-block btn-success">
				</div>
			</form>
		</div>
	</div>

	<div class="col-lg-5">
		<h2 class="title-block">Evolución de Ingresos</h2>

		<div class="row">
			<canvas id="chartIngresos" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" height="350"></canvas>
		</div>

		<div class="row">
			<div class="col-lg-8">
				<form class="form-inline">
					<div class="form-group">
						<label>Mostrar evolución de</label>
						<select class="form-control" name="year" id="year">
							@forelse ($years as $year)
							<option value="{{ $year->year }}">{{ $year->year }}</option>
							@empty
							<p class="alert alert-info">No se puede seleccionar el año</p>
							@endforelse
						</select>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

{{-- Se añade los scripts necesarios para la vista Ingresos --}}
@push('scriptsIngresos')
<script src="js/scriptIngresos.js"></script>
@endpush