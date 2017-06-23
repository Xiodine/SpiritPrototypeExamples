@extends ('layouts.mobile')

@section ('content')
   <h3>{{ $vehicle->registration }}</h3>
   <div class="container-fluid">
      <div class="row">
	 <div class="col-xs-2"></div>
	 <div class="col-xs-8">
	    <a href="/mobile/check/new/{{ $vehicle->id }}" class="btn btn-primary large">Initiate Check</a>
	 </div>
	 <div class="col-xs-2"></div>
      </div>
      <h3>Checks</h3>
      <table class="table table-hover table-bordered" id="checkTable">
	 <tr>
	    <th>Created</th>
	    <th>Passed</th>
	 </tr>
	 @foreach ($checks as $check)
	    <tr data-object="check" data-object-id="{{ $check->id }}">
	       <td>{{ $check->created_at }}</td>
	       @if ($check->passed == 1)
		  <td class="success"><span class="glyphicon glyphicon-ok"></span></td>
	       @elseif ($check->passed == 2)
		  <td class="danger"><span class="glyphicon glyphicon-remove"></span></td>
	       @elseif ($check->passed == 0)
		  <td class="info"><span class="glyphicon glyphicon-time"></span></td>
	       @endif    
	    </tr>
	 @endforeach
      </table>
      <div class="row">
	 <div class="col-xs-2"></div>
	 <div class="col-xs-8 text-center">
	    {{ $checks->links() }}
	 </div>
	 <div class="col-xs-2"></div>
      </div>
   </div>
@endsection
