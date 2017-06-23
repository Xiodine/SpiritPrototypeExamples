<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
   public function vehicles()
   {
      return $this->hasMany('App\Vehicle');
   }

   public function questions()
   {
      return $this->hasMany('App\Question');
   }
}
