@extends('layouts.master')

@section('content')
<h1>Vehicle {{ $vehicle->registration }}</h1>
<table class="table table-bordered" id="checkTable">
   <tr>
      <th>Vehicle ID</th>
      <td>{{ $vehicle->id }}</td>
   </tr>
   <tr>
      <th>Type</th>
      <td><a href="/type/{{ $vehicle->type->id }}">{{ $vehicle->type->name }}</a></td>
   </tr>
   <tr>
      <th>Registration</th>
      <td>{{ $vehicle->registration }}</td>
   </tr>
   <tr>
      <th>Last Recorded Mileage</th>
      <td>{{ $vehicle->checks->count() > 0 ? $vehicle->checks()->orderBy('id', 'desc')->first()->mileage : "N/A"}}</td>
   </tr>
</table>

<h1>Checks</h1>
<table class="table table-hover table-bordered" id="checkTable">
   <tr>
      <th>Check Number</th>
      <th>Created</th>
      <th>Passed</th>
   </tr>
   @foreach ($checks as $check)
      <tr data-object="check" data-object-id="{{ $check->id }}">
	 <td>{{ $check->id }}</td>
	 <td>{{ $check->created_at }}</td>
	 @if ($check->status == 1)
	    <td class="success"><span class="glyphicon glyphicon-ok"></span></td>
	 @elseif ($check->status == 0)
	    <td class="info"><span class="glyphicon glyphicon-time"></span></td>
	 @elseif ($check->status == 2)
	    <td class="danger"><span class="glyphicon glyphicon-remove"></span></td>
	 @endif    
      </tr>
   @endforeach
   @if ($vehicle->checks()->count() == 0)
      <tr>
	 <td colspan="3">Nothing to display</td>
      </tr>
   @endif
</table>
@endsection
