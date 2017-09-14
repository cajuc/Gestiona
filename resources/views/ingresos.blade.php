@extends('master')
@section('title', $title)
@section('content-body')
<div class="row">
	<div class="col-lg-8">
		<h2 class="title-block">Fondos actuales - <b>{{ $fondos }} €</b></h2>
	</div>
</div>
<div class="row">
	<div class="col-lg-8">
		<h2 class="title-block">Historial de Ingresos</h2>
		@if (Session::get('message'))
		<div class="alert alert-success text-center" role="alert">
			{{ Session::get('message') }}
		</div>
		@endif
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
						<form method="post">
							{{ method_field('PUT') }}
							{{ csrf_field() }}
							<td>
								<div class="form-group">
									<input type="text" class="form-control" id="formConcepto" name="concepto">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="date" class="form-control" name="fecha" id="formFecha">
								</div>
							</td>
							<td>
								<div class="form-group">
									<input type="number" class="form-control" name="cantidad" id="formCantidad">
								</div>
							</td>
							<td>
								<div class="form-group">
									<textarea name="comentario" class="form-control" rows="2" id="formComentario" maxlength="255"></textarea>
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
	</div>
	<div class="col-lg-4">
		<h2 class="title-block">Evolución de Ingresos</h2>
	</div>
</div>
<div class="row">
	<div class="col-lg-8">
		<h2 class="title-block">Crear nuevo ingreso</h2>
		<div class="row">
			<form action="{{ url('/') }}/ingresos/crear" method="post">
				{{ csrf_field() }}
				<div class="col-lg-4">
					<div class="form-group">
						<input type="text" name="concepto" placeholder="Concepto" class="form-control">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group">
						<input type="date" name="fecha" value="" placeholder="Fecha" class="form-control">
					</div>
				</div>
				<div class="col-lg-3">
					<div class="form-group">
						<input type="number" name="cantidad" value="" placeholder="Cantidad" class="form-control">
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-lg-12">
					<div class="form-group">
						<textarea name="comentario" placeholder="Comentario" class="form-control"></textarea>
					</div>
				</div>
				<div class="col-lg-12">
					<input type="submit" name="crear" value="Nuevo Ingreso" class="btn btn-lg btn-block btn-success">	
				</div>
			</form>
		</div>
	</div>
</div>
@endsection