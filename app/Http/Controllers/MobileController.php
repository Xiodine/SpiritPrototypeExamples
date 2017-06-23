<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class MobileController extends Controller
{
   public function show()
   {
      return view('dashboard');
   }
}
