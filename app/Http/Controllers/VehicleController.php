<?php

namespace App\Http\Controllers;

use App\Vehicle;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
   public function show($id)
   {
      $vehicle = Vehicle::findOrFail($id);
      $checks = $vehicle->checks()->orderBy('id', 'desc')->paginate(10);
      foreach($checks as $check)
      {
	 $check->passed = 1;
	 if($check->finished_at == null)
	 {
	    $check->passed = 0;
	    continue;
	 }
	 foreach($check->responses as $response)
	 {
	    if($response->response == 0)
	    {
	       $check->passed = 2;
	    }
	 }
      }
      return view('vehicle.show', compact('vehicle', 'checks'));
   }

   public function showMobile($id)
   {
      $vehicle = Vehicle::findOrFail($id);
      $checks = $vehicle->checks()->orderBy('id', 'desc')->paginate(5);
      foreach($checks as $check)
      {
	 $check->passed = 1;
	 if($check->finished_at == null)
	 {
	    $check->passed = 0;
	    continue;
	 }
	 foreach($check->responses as $response)
	 {
	    if($response->response == 0)
	    {
	       $check->passed = 2;
	    }
	 }
      }
      return view('vehicle.showMobile', compact('vehicle', 'checks'));
   }

   public function all()
   {
      $vehicles = Vehicle::all();
      return view('vehicle.all', compact('vehicles'));
   }
   
   public function delete($id)
   {
      $vehicle = Vehicle::findOrFail($id);
      if($vehicle->checks()->count() == 0)
      {
	 Vehicle::destroy($vehicle);
      }
   }

   public function add(Request $request)
   {
      $vehicle = new Vehicle();
      $vehicle->type_id = $request->vehicleTypes;
      $vehicle->registration = $request->vehicleReg;
      $vehicle->save();
   }
}
