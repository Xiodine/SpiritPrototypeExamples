@extends('layouts.master')

@section('content')
<h1>Vehicle Types</h1>
<table class="table table-bordered table-hover" id="table-type">
   <tr>
      <th>Name</th>
      <th>Vehicle Count</th>
   </tr>
   @foreach ($types as $type)
      <tr data-object="type" data-object-id="{{ $type->id }}">
	 <td>{{ $type->name }}</td>
	 <td>{{ $type->vehicles()->count() }}</td>
	 <td><button class="btn btn-xs btn-danger delete-button" {{ $type->vehicles()->count() > 0 ? "disabled" : "" }} data-object="type" data-object-id="{{ $type->id }}"><span class="glyphicon glyphicon-remove"></span></button></td>
      </tr>
   @endforeach
</table>
<button id="btnAddNewType" class="btn btn-success">Add New Type</button>
@endsection
