@extends ("layouts.mobile")

@section ("content")
   <h3>Recent Vehicles</h3>
   <div class="container-fluid">
      <div class="row">
	 <div class="col-xs-6">
	    <ul class="nav nav-pills nav-justified">
	       @foreach (\App\Vehicle::orderBy('updated_at', 'desc')->take(3)->get() as $vehicle)
		  <li role="presentation" class="active"><a href="/mobile/vehicle/{{ $vehicle->id }}">{{ $vehicle->registration }}</a></li>
	       @endforeach
	    </ul>
	 </div>
	 <div class="col-xs-6">
	    <ul class="nav nav-pills nav-justified">
	       @foreach (\App\Vehicle::orderBy('updated_at', 'desc')->skip(3)->take(3)->get() as $vehicle)
		  <li role="presentation" class="active"><a href="/mobile/vehicle/{{ $vehicle->id }}">{{ $vehicle->registration }}</a></li>
	       @endforeach
	    </ul>
	 </div>
      </div>
      <h3>In Progress</h3>
      <div class="row">
	 <div class="col-xs-12">
	    <table class="table">
	       <tr>
		  <th>Registration</th>
		  <th>Created</th>
	       </tr>
	       @foreach (\App\Check::where('finished_at', null)->orderBy('id', 'desc') as $check)
		  <tr>
		     <td><a href="/mobile/vehicle/{{ $check->vehicle->id }}">{{ $check->vehicle->registration }}</a></td>
		     <td>{{ $check->created_at }}</td>
		  </tr>
	       @endforeach
	    </table>
	 </div>
      </div>
   </div>
@endsection
