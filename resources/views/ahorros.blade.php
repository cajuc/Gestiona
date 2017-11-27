@extends('master')
@section('title', $title)
@section('content-body')
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
	</div>
</div>
<div class="chart-container">
	<canvas id="chartAhorros"></canvas>
</div>
@endsection


{{-- Se añade los scripts necesarios para la vista Ahorros --}}
@push('scriptsAhorros')
<script src="js/scriptAhorros.js"></script>
@endpush