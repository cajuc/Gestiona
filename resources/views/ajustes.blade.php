@extends('master')
@section('title', $title)
@section('content-body')
<div class="row">
	@if ($errors->any())
	<div class="col-lg-6 col-lg-offset-3">
		<ul class="alert alert-danger">
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>	
			@endforeach
		</ul>
	</div>
	@endif

	@if (session('message'))
	<div class="alert alert-success">{{ session('message') }}</div>
	@endif

	<div class="col-lg-6">
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

	<div class="col-lg-6">
		<h2 class="title-block">Cambiar imagen</h2>
		<div class="row">
			<div class="col-xs-6 col-sm-3 col-md-3 col-lg-3 pull-left">
				<img src="images/{{ $user->image }}" class="img-rounded user-image">
			</div>
			<div class="col-xs-6 col-sm-9 col-md-9 col-lg-9 pull-left">
				<form action="{{ url('/ajustes/image') }}" method="post" enctype="multipart/form-data" class="form-inline">
					{{ csrf_field() }}
					<input type="file" id="input-file" name="image" accept="image/*" class="inputfile inputfile-1" data-multiple-caption="{count} archivos seleccionados">
					<label for="input-file">
						<svg xmlns="http://www.w3.org/2000/svg" class="ajustes-inputfile" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg>
						<span class="ajustes-inputfile">Seleccionar archivo</span>
					</label>
					<button type="submit" class="btn btn-primary btn-block btn-lg">Cambiar</button>
				</form>
			</div>
		</div>
	</div>
	<br>
</div>
@endsection

{{-- Se añade los scripts necesarios para la vista Ajustes --}}
@push('scriptsAjustes')
<script src="js/jquery.custom-file-input.js"></script>
@endpush