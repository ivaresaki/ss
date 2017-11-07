@extends('layouts.app')

@section('content')

<div class="row">
	@forelse($registrations as $r)
	<div class="col-md-4 col-sm-6 col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				{{ $r->name }} : [ <a href="{{route('signup.show', $r)}}">{{ $r->registration_id }}</a> ]
			</div>
			<div class="panel-body">
					<small>Created by {{ $r->owner->name }} {{ $r->created_at->diffForHumans() }}
			</div>
		</div>
	</div>
	@empty
		<p>
			Register for a site <a href="{{ route('signup.create') }}">here</a>.
		</p>
	@endforelse
</div>
@endsection
