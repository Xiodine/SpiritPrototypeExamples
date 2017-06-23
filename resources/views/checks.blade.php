@extends('layouts.master')

@section ('content')
<h1>Checks</h1>
<form method="GET">
   <div class="panel panel-default">
      <div class="panel-body">
	 <div class="container-fluid">
	    <div class="row">
	       <div class="col-md-3">
		  <input type="text" {!! $filters['date'] ? 'value="'.$filters['date'].'"' : '' !!} placeholder="Date Range" class="form-control" name="date" id="dateRangeFilter"/>
	       </div>
	       <div class="col-md-3 text-center">
		  <div class="btn-group" data-toggle="buttons">
		     <label class="btn btn-success {{ $filters['passed'] ? "active" : "" }}">
			<input type="checkbox" autocomplete="off" name="passed" {{ $filters['passed'] ? "checked" : "" }}><span class="glyphicon glyphicon-ok"></span>
		     </label>
		     <label class="btn btn-danger {{ $filters['failed'] ? "active" : "" }}">
			<input type="checkbox" autocomplete="off" name="failed" {{ $filters['failed'] ? "checked" : "" }}><span class="glyphicon glyphicon-remove"></span>
		     </label>
		     <label class="btn btn-info {{ $filters['in-progress'] ? "active" : "" }}">
			<input type="checkbox" autocomplete="off" name="in-progress" {{ $filters['in-progress'] ? "checked" : "" }}><span class="glyphicon glyphicon-time"></span>
		     </label>
		  </div>
	       </div>
	       <div class="col-md-3">
		  <input type="text" placeholder="Registration" name="reg" class="form-control"/>
	       </div>
	       <div class="col-md-3">
		  <select class="form-control" name="filterType">
		    <option value="">Vehicle Type</option> 
		  </select>
	       </div>
	    </div>
	 </div>
      </div>
      <div class="panel-footer text-right">
	 <a class="btn btn-default" href="/">Clear</a>
	 <input type="submit" class="btn btn-success" value="Apply"/>
      </div>
   </div>
</form>

<table class="table table-bordered table-hover" id="checkTable">
   <tr>
      <th>Check ID</th>
      <th>Registration</th>
      <th>Created</th>
      <th>Passed</th>
   </tr>
   @foreach ($checks as $check)
      <tr data-object="check" data-object-id="{{ $check->id }}">
	 <td>{{ $check->id }}</td>
	 <td><a href="/vehicle/{{ $check->vehicle->id }}">{{ $check->vehicle->registration }}</a></td>
	 <td>{{ $check->created_at }}</td>
	 @if ($check->status == 1)
	    <td class="success"><span class="glyphicon glyphicon-ok"></span></td>
	 @elseif ($check->status == 2)
	    <td class="danger"><span class="glyphicon glyphicon-remove"></span></td>
	 @elseif ($check->status == 0)
	    <td class="info"><span class="glyphicon glyphicon-time"></span></td>
	 @endif    
      </tr>
   @endforeach
</table>
{{ $checks->links() }}
@endsection
