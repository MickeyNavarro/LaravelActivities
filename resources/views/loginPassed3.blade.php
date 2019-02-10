@extends('layouts.appmaster')
@section('title', 'Login Page')

@section('content')
 	@if($model->getUsername() == 'Mickey') 
 		<h3>Mickey you have logged in successfully</h3>
 	@else 
 		<h3>Someone besides Mickey logged in successfully</h3>
 	@endif 
 		<br> 
 		<a href="login3">Login Again</a>
@endsection