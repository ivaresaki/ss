@extends('layouts.app')

@section('content')

<div class="container">
    <h3>Register a new Site</h3>
    <form action="{{ route('signup.store') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
           <label for="name">Site Name</label>
           <input class="form-control" id="name" name="name"
                placeholder="Enter name of the Site" 
                value="{{ old('name') }}">
            @include('partials.fielderror', ['fieldname'=>'name'])
       </div> 
       <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
           <label for="name">Site Address</label>
           <textarea class="form-control" id="address" name="address"
                placeholder="Enter address">{{ old('address') }}</textarea>
            @include('partials.fielderror', ['fieldname'=>'address'])
       </div> 
       <div class="form-group {{ $errors->has('poc_name') ? 'has-error' : '' }}">
           <label for="name">Point Of Contact Name</label>
           <input class="form-control" id="poc_name" name="poc_name"
                placeholder="Name of the point fo contact" 
                value="{{ old('poc_name') }}">
            @include('partials.fielderror', ['fieldname'=>'poc_name'])
       </div> 
       <div class="form-group {{ $errors->has('poc_email') ? 'has-error' : '' }}">
           <label for="name">Point of Contact Email</label>
           <input class="form-control" id="poc_email" name="poc_email"
                placeholder="Email for POC" 
                value="{{ old('poc_email') }}">
            @include('partials.fielderror', ['fieldname'=>'poc_email'])
       </div> 
       <div class="form-group {{ $errors->has('poc_phone') ? 'has-error' : '' }}">
           <label for="name">Point Of Contact Phone</label>
           <input class="form-control" id="poc_phone" name="poc_phone"
                placeholder="Phone for POC" 
                value="{{ old('poc_phone') }}">
            @include('partials.fielderror', ['fieldname'=>'poc_phone'])
       </div>
       <input class="btn btn-info" type="submit" value="Register">
   </form>
</div>
@endsection
