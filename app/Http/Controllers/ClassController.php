<?php

namespace App\Http\Controllers;
use App\Models\Classes;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ClassStoreRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class ClassController extends Controller
{
    //
    public function index(){
        $class = Classes::all();
        return    response()->json(["data"=>$class], 200);
    } 

    public function show($id){
       
        $class= Classes::find($id);
     //    dd($class);
        if(!$class){
         return  response()->json(['message'=>'class not found'],404);
        }else{
         return  response()->json(["data"=>$class],200);
        }
 }
 public function store(ClassStoreRequest $request){
    if ($request->has('emploi_de_temps')) {
        $image=$request->file('emploi_de_temps');
        $name=time(). '.' .$image->getClientOriginalExtension();
        $image->move('images/',$name);
    }
     
      Classes::create([
        'nom_de_class'=>$request->input('nom_de_class'),
        'emploi_de_temps'=>$name,
    ]);
    return response()->json(['message'=>'Create Class success'],200);
     
        
  }

  public function update(ClassStoreRequest $request, $id){
    $class= Classes::find($id);
        
       if (!$class) {
          return response()->json(['message'=>"Not Found"],404);
       }
        dd($request->has('emploi_de_temps'));
       if ($request->has('emploi_de_temps')) {
        $image=$request->file('emploi_de_temps');
        $name=time(). '.' .$image->getClientOriginalExtension();
        $image->move('images/',$name);
        dd($name);
    }
       $class ->update([
        'nom_de_class'=>$request->input('nom_de_class',$class->nom_de_class),
        //'emploi_de_temps'=>$name,
      ]);
      return response()->json(['message'=>'Update Successfully'],200);
   }
    public function destroy($id){
        $class=Classes::find($id);
        if (!$class) {
            return  response()->json(['message'=>'class Not Found'],200);
        }
        $class->enseignants()->detach();
        
        $class->delete();
        return response()->json(['message'=>'class deleted'],200);
    }
}
