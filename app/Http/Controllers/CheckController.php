<?php

namespace App\Http\Controllers;

use App\Check;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckController extends Controller
{
   public function show($id)
   {
      $check = Check::findOrFail($id);
      return view('check.show', compact('check'));
   }
   public function listChecks(Request $request)
   {
      $checks = Check::orderBy('id', 'desc');
      $filters = [
	 "date"		=> $request->input("date"),
	 "passed"	=> $request->input("passed"),
	 "failed"	=> $request->input("failed"),
	 "in-progress" 	=> $request->input("in-progress"),
	 "type"		=> $request->input("type")
      ];
   
      if($filters['date'])
      {
	 $dates = explode(" - ", $filters["date"]);
	 if(count($dates == 2))
	 {
	    $dates[0] = date("Y-m-d", strtotime($dates[0]));
	    $dates[1] = date("Y-m-d", strtotime($dates[1]));
	    $checks->whereBetween("created_at", [$dates[0], $dates[1]]);
	 }
      }

      if($filters["passed"] || $filters["failed"] || $filters["in-progress"])
      {
	 if(!$filters["passed"])
	 {
	    $checks->where("status", "!=", 1);
	 }
	 if(!$filters["failed"])
	 {
	    $checks->where("status", "!=", 2);
	 }
	 if(!$filters["in-progress"])
	 {
	    $checks->where("status", "!=", 0);
	 }
      }

      $checks = $checks->paginate(10);
      $checks->appends($request->all());

      return view('checks', compact('checks', 'filters'));
   }

   public function newCheck($vehicleId)
   {
      $vehicle = \App\Vehicle::findOrFail($vehicleId);
      $check = new Check();
      $check->vehicle()->associate($vehicle);
      $check->save();

      $type = $vehicle->type()->first();
      $questions = $type->questions();
      foreach($questions->get() as $question)
      {
	 $response = new \App\Response();
	 $response->question()->associate($question);
	 $response->check()->associate($check);
	 $response->response = false;
	 $response->save();
      }

      $vehicle->updated_at = new \DateTime();
      $vehicle->save();

      return redirect()->route('mobile/check', [$check->id]);
   }

   public function showCheck($id)
   {
      $check = Check::findOrFail($id);
      return view("check.showMobile", compact('check'));
   }

   public function update($id, Request $request)
   {
      $check = Check::findOrFail($id);
      $check->mileage = $request->input("mileage");
      foreach($request->input("responses") as $responseId => $value)
      {
	 $response = \App\Response::findOrFail($responseId);
	 $response->response = $value == "true" ? 1 : 0;
	 $response->save();
      }
      
      $date = new \DateTime();
      if($request->input("signOff") == "true")
      {
	 $check->finished_at = $date;
	 $check->status = 1;
	 foreach($check->responses as $response)
	 {
	    if($response == false) 
	    {
	       $check->status = 2;
	    }
	 }
      }
      $check->save();

      $check->vehicle()->updated_at = $date;
      $check->vehicle->save();
   }
}
