@extends('layouts.app')

@section('content')

<div>
	<form action="{{ route('signup.approve', $registration) }}" method="post">
		{{ csrf_field() }}
		<div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
			<label for="slug">Subdomain</label>
			<input class="form-control" type="text" id="slug" name="slug"
			placeholder="Subdomain for the site"
			value="{{ old('slug') }}">
			@include('partials.fielderror', ['fieldname'=>'slug'])
		</div>
		<input class="btn btn-success" type="submit" value="Approve">
		<a class="btn btn-danger" href="{{ route('logout') }}"
		onclick="event.preventDefault();
        document.getElementById('reject-form').submit();">
    		Reject
    	</a>
	</form>
	<form id="reject-form" action="{{ route('signup.reject', $registration) }}" method="post" style="display: none;">
		{{ csrf_field() }}
	</form>
</div>

<hr/>
<h3>Site Details:</h3>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title pull-left">{{ $registration->registration_id }}</h3>
		<div class="dropdown pull-right">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<span><i class="fa fa-cog"></i></span> Action
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li><a href="#"><span><i class="fa fa-pencil"></i></span> Edit</a></li>
				<li><a href="#"><span><i class="fa fa-trash"></i></span> Delete</a></li>
			</ul>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="panel-body">

		<div class="row">
			<div class="col-sm-6">
				<dl>
					<dt>Site Name</dt>
					<dd>{{ $registration->name }}</dd>
				</dl>
				<dl>
					<dt>Address</dt>
					<dd>{!! nl2br($registration->address) !!}</dd>
				</dl>
				<dl>
					<dt>Approval Status</dt>
					<dd>
						{{ ucfirst($registration->approval) }}

						@if(isset($registration->approver))
							by {{ $registration->approver->name }}
						@endif
					</dd>
				</dl>
			</div>
			<div class="col-sm-6">
				<dl>
					<dt>POC</dt>
					<dd>{{ $registration->poc_name }}</dd>
				</dl>
				<dl>
					<dt>Email</dt>
					<dd>{{ $registration->poc_email }}</dd>
				</dl>
				<dl>
					<dt>Phone</dt>
					<dd>{{ $registration->poc_phone }}</dd>
				</dl>
			</div>
		</div>
	</div>
	<div class="panel-footer">
		<small>Updated by {{ $registration->owner->name }} at {{ $registration->updated_at->diffForHumans() }}</small>
	</div>
</div>

@endsection
