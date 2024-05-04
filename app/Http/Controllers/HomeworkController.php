<?php

namespace App\Http\Controllers;

use App\Models\Homework;
use App\Http\Requests\HomeworkStoreRequest;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{
    
    public function enseignant($enseignantId)
{
    $homework = Homework::whereHas('enseignants', function ($query) use ($enseignantId) {
        $query->where('enseignant_id', $enseignantId);
    })->orderBy('created_at', 'desc')->get();

    return response()->json(["data" => $homework], 200);
}
    public function index()
    {
        $homework = Homework::orderBy('created_at', 'desc')
        ->with(['enseignants' => function ($query) {
            $query->with('matieres', 'classes');
        }])
        ->get();       
         return response()->json(["data" => $homework], 200);
    }


    public function show($id){
       
        $Homework= Homework::find($id);
     //    dd($Homework);
        if(!$Homework){
         return  response()->json(['message'=>'Homework not found'],404);
        }else{
         return  response()->json(["data"=>$Homework],200);
        }
 }
 public function store(HomeworkStoreRequest $request){
   
  
     
    $homework= Homework::create([
          'title'=>$request->input('title'),
          'description'=>$request->input('description'),
          'enseignant_id'=>$request->input('enseignant_id'),
          $class_ids = $request->input("classes_ids"),
            
        ]);
        $homework->classes()->sync($class_ids);
      return response()->json(['message'=>'Create Homework success'],200);
  }
  public function update(Request $request, $id){
    $homework= Homework::find($id);
       if (!$homework) {
          return response()->json(['message'=>"Not Found"],404);
       }
       $homework ->update([
         'title'=>$request->input('title',$homework->title),
         'description'=>$request->input('description',$homework->description),
       ]);
       return response()->json(['message'=>'Update Successfully'],200);
    }
    public function destroy($id){
        $homework=Homework::find($id);
        if (!$homework) {
            return   response()->json(['message'=>'homework Not Found'],200);
        }
        $homework->classes()->detach();

        $homework->delete();
        return response()->json(['message'=>'homework deleted'],200);
    }
}
