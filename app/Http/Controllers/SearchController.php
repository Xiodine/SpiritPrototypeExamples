<?php

namespace App\Http\Controllers;

use App\Check;
use App\Vehicle;
use App\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
   public function search(Request $request)
   {
      $term = $request->input("search");
      $vehicles = Vehicle::where("registration", 'like', "%" . $term . "%")->get();
      $types = Type::where("name", 'like', "%" . $term . "%")->get();
      return view("search", compact("vehicles", "types"));
   }
}
