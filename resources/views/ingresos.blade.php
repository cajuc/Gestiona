@extends('master')
@section('title', $title)
@section('content-body')
<div>
	<h2 class="title-block">Fondos actuales - <b>{{ $fondos }} €</b></h2>
	<span></span>
</div>
<div class="row">
	<div class="col-lg-8">
		<h2 class="title-block">Historial de Ingresos</h2>
		@if (Session::get('message'))
		<div class="alert alert-success text-center" role="alert">
			{{ Session::get('message') }}
		</div>
		@endif
		<div class="table table-responsive">
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
						<td class="text-capitalize">{{ $ingreso->concepto }}</td>
						<td>{{ $ingreso->fecha }}</td>
						<td>{{ $ingreso->cantidad }} €</td>
						<td class="text-justify">{{ $ingreso->comentario }}</td>
						<td>
							<div class="btn-toolbar" role="toolbar">
								<div class="btn-group">
									<form action="{{ url('ingresos') }}/{{ $ingreso->id }}" method="post">
										{{ method_field('DELETE') }}
										{{ csrf_field() }}
										<button type="submit" class="btn btn-default btn-md">
										<span style="color: red" class="glyphicon glyphicon-trash"></span>
										</button>
									</form>
								</div>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<nav class="text-center" aria-label="mostrar ingresos">
				{{ $ingresos->links() }}
			</nav>
		</div>
	</div>
	<div class="col-lg-4">
		<h2 class="title-block">Evolución de Ingresos</h2>
	</div>
</div>
@endsection