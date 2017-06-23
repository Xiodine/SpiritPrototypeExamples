<?php

namespace App\Http\Controllers;

use App\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeController extends Controller
{
   public function allJson()
   {
      return Type::all()->toJson();
   }

   public function all()
   {
      $types = Type::all();
      return view('type.all', compact('types'));
   }

   public function show($id)
   {
      $type = Type::findOrFail($id);
      return view('type.show', compact('type'));
   }

   public function add(Request $request)
   {
      $type = new Type();
      $type->name = $request->input("typeName");
      $type->save();
   }

   public function delete($id)
   {
      $type = Type::findOrFail($id);
      if($type->vehicles()->count() == 0)
      {
	 $type->delete();
      }
   }

   public function copyFrom($fromId, $toId)
   {
      $type = Type::findOrFail($fromId);
      foreach($type->questions as $question)
      {
	 $newQuestion = new \App\Question();
	 $newQuestion->question = $question->question;
	 $newQuestion->type_id = $toId;
	 $newQuestion->save();
      }
   }
}
