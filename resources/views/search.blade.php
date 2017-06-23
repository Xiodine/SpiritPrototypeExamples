@extends ("layouts.master")

@section ("content")
@if ($vehicles->count() > 0)
   <h1>Vehicles</h1>
   <table class="table table-bordered table-hover" data-model="vehicle">
      <tr>
	 <th>Registration</th>
	 <th>Type</th>
      </tr>
      @foreach ($vehicles as $vehicle)
	 <tr data-object="vehicle" data-object-id="{{ $vehicle->id }}">
	    <td>{{ $vehicle->registration }}</td>
	    <td>{{ $vehicle->type->name }}</td>
	 <tr>
      @endforeach
   </table>
@endif

@if ($types->count() > 0)
   <h1>Types</h1>
   <table class="table table-bordered table-hover" data-object="type">
      <tr>
	 <th>Name</th>
	 <th>Vehicle Count</th>
      </tr>
      @foreach ($types as $type)
	 <tr data-object="type" data-object-id="{{ $type->id }}">
	    <td>{{ $type->name }}</td>
	    <td>{{ $type->vehicles()->count() }}</td>
	 <tr>
      @endforeach
   </table>
@endif
@endsection
