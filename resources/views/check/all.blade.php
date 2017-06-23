@extends('layouts.master')

@section('content')
<h1>All Vehicles</h1>
<table class="table table-bordered" id="table-vehicle">
   <tr>
      <th>Vehicle ID</th>
      <th>Registration</th>
      <th>Type</th>
      <th></th>
   </tr>
   @foreach ($vehicles as $vehicle)
      <tr>
	 <td>{{ $vehicle->id }}</td>
	 <td><a href="/vehicle/{{ $vehicle->id }}">{{ $vehicle->registration }}</a></td>
	 <td><a href="/type/{{ $vehicle->type->id }}">{{ $vehicle->type->name }}</a></td>
	 <td>
	    <button class="btn btn-xs btn-danger delete-button" {{ $vehicle->checks()->count() > 0 ? "disabled" : "" }} data-object="vehicle" data-object-id="{{ $vehicle->id }}">
	       <span class="glyphicon glyphicon-remove"></span>
	    </button>
	 </td>
      </tr>
   @endforeach
</table>
<button id="btnAddNewVehicle" class="btn btn-success">Add New Vehicle</button>
@endsection
