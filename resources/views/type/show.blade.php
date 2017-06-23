@extends('layouts.master')

@section('content')
<h1>{{ $type->name }}</h1>
<table class="table table-bordered" id="checkTable">
   <tr>
      <th>Name</th>
      <td><input type="text" class="form-control" id="typeName" value="{{ $type->name }}"/></td>
      <td><button class="btn btn-success" id="updateType">Update</button></td>
   </tr>
</table>

<h3>Questions</h3>
<table class="table table-bordered">
   <tr>
      <th>Question</th>
      <th></th>
   </tr>
   @foreach ($type->questions as $question)
      <tr>
	 <td>{{ $question->question }}</td>
	 <td><button class="btn btn-danger btn-xs delete-button" data-object="type" data-object-id="{{ $question->id }}"><span class=" glyphicon glyphicon-remove"></span></button></td>
      </tr>
   @endforeach
</table>
<button class="btn btn-success" id="btnAddNewQuestion">Add Question</button>
<button class="btn btn-primary" id="btnAddQFromVehicle" data-toggle="modal" data-target="#modalCopyQs">Copy Questions</button>
<h3>Related Vehicles</h3>
<table class="table table-bordered" id="checkTable">
   <tr>
      <th>Vehicle ID</th>
      <th>Registration</th>
   </tr>
   @foreach ($type->vehicles as $vehicle)
      <tr>
	 <td>{{ $vehicle->id }}</td>
	 <td><a href="/vehicle/{{ $vehicle->id }}">{{ $vehicle->registration }}</a></td>
      </tr>
   @endforeach
</table>

<div class="modal fade" tabindex="-1" role="dialog" id="modalCopyQs">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Copy From Existing Type</h4>
      </div>
      <div class="modal-body">
	<select class="form-control" id="selectType" data-current-type="{{ $type->id }}">
	    @foreach (\App\Type::where("id", "!=", $type->id)->get() as $newType)
	       <option value="{{ $newType->id }}">{{ $newType->name }}</option>
	    @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="btnCopyQs" class="btn btn-primary">Copy</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
