@extends('master')
@section('title', $title)
@section('body')
	<h1>Bienvenido {{ Auth::user()->name}}</h1>
@endsection