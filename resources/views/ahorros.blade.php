@extends('master');
@section('title', $title)
@section('content-body')
<div class="row">
	<div class="col-lg-12">
		<h2 class="title-block">Evolución de Ahorros</h2>
		<form class="form-inline">
					<div class="form-group">
						<label>Evolución de </label>
						<select class="form-control" name="year" id="year">
							@forelse ($years as $year)
							<option value="{{ $year->year }}">{{ $year->year }}</option>
							@empty
							<p class="alert alert-info">No se puede seleccionar el año</p>
							@endforelse
						</select>
					</div>
				</form>
		<br>
		<div id="chartAhorros-container"></div>
	</div>
</div>
@endsection