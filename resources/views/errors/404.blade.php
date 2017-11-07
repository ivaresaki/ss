@extends('layouts.app')

@section('content')

<div>
	<div class="alert alert-warning" role="alert">
		<h3>This resource is not available</h3>
	</div>
	<a class="btn btn-info" href="{{ URL::previous() }}">Return back</a>
</div>

@endsection