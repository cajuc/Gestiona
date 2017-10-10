@extends('master')
@section('title', $title)
@section('content-body')
<div class="row">
	<div class="col-lg-6">

		@if ($errors->any())
			<ul class="alert alert-danger">
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>	
				@endforeach
			</ul>
		@endif

		@if (session('message'))
			<div class="alert alert-success">{{ session('message') }}</div>
		@endif

		<form action="{{ url('ajustes') }}" method="POST">
			{{ csrf_field() }}
			<h2 class="title-block">Datos personales</h2>
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group">
						<input type="text" class="form-control" name="name" value="{{ old('name') ? old('name') : $user->name }}">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" name="surnames" value="{{ old('surnames') ? old('surnames') : $user->surnames }}">
					</div>
				</div>
			</div>

			<h2 class="title-block">Contraseña</h2>
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group">
						<input id="password" type="password" class="form-control" name="password" placeholder="Contraseña">
					</div>
					<p class="text-danger" id="messagePassword" style="display: none;">Debe contener almenos un número, una mayúscula y una minúscula (8 caracteres como mínimo)</p>
					<div class="form-group">
						<input id="rePassword" type="password" class="form-control" name="rePassword" placeholder="Repite contraseña">
					</div>
				</div>
			</div>

			<h2 class="title-block">Fondos Actuales - €</h2>
			<div class="row">
				<div class="col-lg-4">
					<div class="form-group">
						<input type="number" min="0" class="form-control" name="fondos" value="{{ $user->fondos }}">
					</div>
				</div>
			</div>

			<button type="submit" name="guardar" class="btn btn-primary btn-block btn-lg">Guardar cambios</button>
		</form>
	</div>
</div>
@endsection