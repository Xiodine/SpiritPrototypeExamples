<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
   public function vehicle()
   {
      return $this->belongsTo('App\Vehicle');
   }

   public function responses()
   {
      return $this->hasMany('App\Response');
   }
}
