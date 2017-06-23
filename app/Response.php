<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
   public function check()
   {
      return $this->belongsTo('App\Check');
   }

   public function question()
   {
      return $this->belongsTo('App\Question');
   }
}
