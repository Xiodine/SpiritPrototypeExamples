<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
   public function type()
   {
      return $this->belongsTo('App\Type');
   }

   public function checks()
   {
      return $this->hasMany('App\Check');
   }
}
