@extends('layouts.app')

@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title pull-left">{{ $registration->registration_id }}</h3>

		@if(str_is('pending', $registration->approval) || request()->role=='admin')
		<div class="dropdown pull-right">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<span><i class="fa fa-cog"></i></span> Action
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li><a href="#"><span><i class="fa fa-pencil"></i></span> Edit</a></li>
				<li><a href="#"><span><i class="fa fa-trash"></i></span> Delete</a></li>
				@role('admin')
				<li role="separator" class="divider"></li>
				<li><a href="{{ route('signup.approval', $registration) }}"><span><i class="fa fa-check"></i></span> Approve</a></li>
				@endrole
			</ul>
		</div>
		@endif
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
