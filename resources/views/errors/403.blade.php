@extends('layouts.app')

@section('content')

<div>
	<div class="alert alert-danger" role="alert">
		<h3>You do not have permission to access this section</h3>
	</div>
	<a class="btn btn-info" href="{{ URL::previous() }}">Return back</a>
</div>

@endsection