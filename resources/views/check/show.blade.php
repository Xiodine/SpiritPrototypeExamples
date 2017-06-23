@extends('layouts.master')

@section('content')
<h1>
   Check #{{ $check->id }} (<a href="/vehicle/{{ $check->vehicle->id }}">{{ $check->vehicle->registration }}</a>)
   @if ($check->finished_at == null)
      <span class="badge">In Progress</span>
   @endif
</h1>
<table class="table table-bordered" id="checkTable">
   <tr>
      <th>Question</th>
      <th>Response</th>
   </tr>
   @foreach ($check->responses as $response)
      <tr>
	 <td>{{ $response->question->question }}</td>
	 @if ($response->response == 1)
	    <td class="success"><span class="glyphicon glyphicon-ok"></span></td>
	 @elseif ($response->response == 0)
	    <td class="danger"><span class="glyphicon glyphicon-remove"></span></td>
	 @endif
      </tr>
   @endforeach
   <tr>
      <th>Mileage</th>
      <td>{{ $check->mileage }}</td>
   </tr>
</table>
@endsection
