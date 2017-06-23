@extends('layouts.mobile')

@section('content')
   <h1>Check #{{ $check->id }} (<a href="/mobile/vehicle/{{ $check->vehicle->id }}">{{ $check->vehicle->registration }}</a>)</h1>

   <div class="container-fluid">
      <div class="row">
	 <div class="col-xs-6">Mileage</div>
	 <div class="col-xs-6">
	    <form>
	       <div class="input-group" id="mileageGroup">
		  <input type="number" data-vehicle-id="{{ $check->vehicle->id }}" id="mileage" step="1" min="0" max="999999" class="form-control" placeholder="Mileage" value="{{ $check->mileage }}" {{ $check->finished_at != null ? "disabled" : "" }}>
		  <div class="input-group-addon">miles</div>
	       </div>
	    </form>
	 </div>
      </div>
      @foreach ($check->responses->all() as $response)
	 <div class="row">
	    <div class="col-xs-6">{{ $response->question->question }}</div>
	    <div class="col-xs-6">
	       <button type="button" {{ $check->finished_at != null ? "disabled" : "" }} class="btn btn-check question {{ $response->response ? "active" : "" }}" data-response="{{ $response->id }}" data-toggle="button" aria-pressed="{{ $response->response ? "true" : "false" }}" autocomplete="off"></button>
	    </div>
	 </div>
      @endforeach
      @if ($check->finished_at == null)
	 <div class="row">
	    <div class="col-xs-6">Sign Off?</div>
	    <div class="col-xs-6">
	       <button type="button" id="signOff" class="btn btn-check sign-off" data-toggle="button" aria-pressed="false" autocomplete="off"></button>
	    </div>
	 </div>
	 <div class="row center">
	    <div class="col-xs-12"><button class="btn btn-success large" id="submitCheck" type="button">Submit</button></div>
	 </div>
      @endif
   </div>
@endsection
