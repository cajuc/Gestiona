@extends('master')
@section('title', $title)
@section('content-body')
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-9">
		<h2 class="title-block">Historial de Gastos</h2>
		@if (Session::get('message'))
		<div class="alert text-center {{ Session::get('class') ? Session::get('class') : 'alert-success' }}" role="alert">
			{{ Session::get('message') }}
		</div>
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

		@if (count($gastos))
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="col-sm-2 col-md-2 col-lg-2">Tipo</th>
						<th class="col-sm-3 col-md-3 col-lg-3">Concepto</th>
						<th class="col-sm-1 col-md-1 col-lg-1">Fecha</th>
						<th class="col-sm-1 col-md-1 col-lg-1">Cantidad</th>
						<th class="col-sm-4 col-md-4 col-lg-4">Comentario</th>
						<th class="col-sm-1 col-md-1 col-lg-1"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($gastos as $gasto)
					<tr>
						<td class="text-capitalize" id="tipo-{{ $gasto->id }}">{{ $gasto->tipo }}</td>
						<td class="text-capitalize" id="concepto-{{ $gasto->id }}">{{ $gasto->concepto }}</td>
						<td id="fecha-{{ $gasto->id }}">{{ $gasto->fecha }}</td>
						<td id="cantidad-{{ $gasto->id }}"><span>{{ $gasto->cantidad }}</span> €</td>
						<td class="text-justify" id="comentario-{{ $gasto->id }}" data-value="{{ $gasto->comentario }}">
							<span class="text-abreviado-{{ $gasto->id }}">{{ substr($gasto->comentario, 0, 60) }}</span>
							<span class="text-completo-{{ $gasto->id }}" hidden>{{ $gasto->comentario }}</span>
							{{-- En caso de no haber comentario no se mostrará el enlace --}}
							@if ($gasto->comentario && strlen($gasto->comentario) > 60)
							<span class="label label-default"><a class="show-more" data-state="false" data-show="{{ $gasto->id }}">... más</a></span>
							@endif
						</td>
						<td>
							<form action="{{ url('/gastos/'. $gasto->id) }}" method="post">
								{{ method_field('DELETE') }}
								{{ csrf_field() }}
								<button type="submit" class="btn btn-link" title="Borrar">
									<span style="color: red" class="glyphicon glyphicon-trash"></span>
									<span class="btn-action">Eliminar</span>
								</button>
							</form>
							<button class="btn btn-link editForm" type="button" title="Editar" value="{{ $gasto->id }}">
								<span style="color: blue" class="glyphicon glyphicon-edit"></span>
								<span class="btn-action">Editar</span>
							</button>
						</td>
					</tr>
					@endforeach
					<tr class="formEdit" hidden>
						<form action="" method="post">
							{{ method_field('PUT') }}
							{{ csrf_field() }}
							<td>
								<div class="form-group">
									<input type="text" class="form-control" id="formTipo" name="tipo">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="text" class="form-control" id="formConcepto" name="concepto">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="text" class="form-control datepicker" name="fecha" id="formFecha">
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
								<button class="btn btn-link" type="submit" title="Guardar">
									<span style="color: blue" class="glyphicon glyphicon-save"></span>
									<span class="btn-action">Guardar</span>
								</button>
								<span></span>
								<button id="cerrarForm" class="btn btn-link" type="button" title="Cerrar">
									<span style="color: red" class="glyphicon glyphicon-remove"></span>
									<span class="btn-action">Cerrar</span>
								</button>
							</td>
						</form>
					</tr>
				</tbody>
			</table>
			<nav class="text-center paginacion" aria-label="mostrar gastos">
				{{ $gastos->links() }}
			</nav>
		</div>
		@else
		<div class="alert alert-info">
			No hay registros de gastos todavia!!
		</div>
		@endif

	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
		<h2 class="title-block">Nuevo gasto</h2>
		<div class="row">
			<form action="{{ url('/') }}/gastos/crear" method="post">
				{{ csrf_field() }}
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-btn">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Elegir tipo">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									@foreach ($tipos as $tipo)
									<li><a class="tipo">{{ $tipo }}</a></li>
									@endforeach
								</ul>
							</div>
							<input id="tipoConcepto" type="text" name="tipoConcepto" placeholder="Tipo" class="form-control" disabled>
							<input type="hidden" name="tipo" id="tipo">
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-btn">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Elegir concepto">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" id="dropdownConcepto"></ul>
							</div>
							<input id="concepto" type="text" name="concepto" placeholder="Concepto" class="form-control">
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon glyphicon glyphicon-calendar" id="calendar-addon"></span>
							<input type="text" name="fecha" value="{{ date("Y-m-d") }}" class="form-control  datepicker" aria-label="calendar-addon">
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-12">
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon glyphicon glyphicon-euro" id="cantidad-addon"></span>
							<input type="number" name="cantidad" min="0" placeholder="Cantidad" class="form-control" aria-label="cantidad-addon">
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="form-group">
						<textarea name="comentario" placeholder="Comentario" maxlength="200" rows="3" class="form-control"></textarea>
					</div>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<input type="submit" name="crearGasto" value="Nuevo Gasto" class="btn btn-lg btn-block btn-success">
				</div>
			</form>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h2 class="title-block">Evolución de Gastos</h2>
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
<div class="chart-container">
	<canvas id="chartBarGastos"></canvas>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<h2 class="title-block">Detalles de Gastos</h2>
		<div class="row">
			<div class="col-lg-8">
				<form class="form-inline">
					<div class="form-group">
						<label for="">Seleccionar tipo</label>
						<select class="form-control" id="chartTipo">
							@forelse ($tipos as $tipo)
							<option value="{{ $tipo }}">{{ $tipo }}</option>
							@empty
							<p class="alert alert-info">No existen tipos</p>
							@endforelse
						</select>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="chart-container chart-donut">
	<canvas id="chartDonutGastos"></canvas>
</div>
@endsection

{{-- Se añade los scripts necesarios para la vista Gastos --}}
@push('scriptsGastos')
<script src="js/scriptGastos.js"></script>
@endpush