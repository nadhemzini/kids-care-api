<?php

namespace App\Http\Controllers;

use App\Models\Enfant;
use Illuminate\Http\Request;
use App\Http\Requests\EnfantStoreRequest;


class EnfantController extends Controller
{
    //
    public function index()
    {
        $enfants = Enfant::orderBy('created_at','desc')->with('Parents')->with('classes')->get(); // Eager load the Enfants relationship
        return response()->json(["data" => $enfants], 200);
    }

    public function enfant($parentid)
    {
        $enfant = Enfant::with('Classes') // Eager load the 'class' relationship
                        ->whereHas('parents', function ($query) use ($parentid) {
                            $query->where('parent_id', $parentid);
                        })
                        ->orderBy('created_at', 'desc')
                        ->get();
    
        return response()->json(["data" => $enfant], 200);
    }
    public function show($id){
       
        $enfant= Enfant::find($id);
     //    dd($enfant);
        if(!$enfant){
         return  response()->json(['message'=>'enfant not found'],404);
        }else{
         return  response()->json(["data"=>$enfant],200);
        }
 }
 public function store(EnfantStoreRequest $request){
   
    if ($request->has('image')) {
        $image=$request->file('image');
        $name=time(). '.' .$image->getClientOriginalExtension();
        $image->move('images/',$name);
    }
     
      Enfant::create([
          'fullname'=>$request->input('fullname'),
          'image'=>$name,
          'gender'=>$request->input('gender'),
          'parent_id'=>$request->input('parent_id'),
          'class_id'=>$request->input('class_id'),
      ]);
      return response()->json(['message'=>'Create Enfant success'],200);
  }
  public function update(Request $request, $id){
    $enfant= Enfant::find($id);
       if (!$enfant) {
          return response()->json(['message'=>"Not Found"],404);
       }
      //   dd($request->input());
       $enfant ->update([
         'fullname'=>$request->input('fullname',$enfant->fullname),
         'image'=>$request->input('image',$enfant->image),
         'gender'=>$request->input('gender',$enfant->gender),
         'parent_id'=>$request->input('parent_id',$enfant->parent_id),
         'class_id'=>$request->input('class_id',$enfant->class_id),
         
       ]);
       return response()->json(['message'=>'Update Successfully'],200);
    }
    public function destroy($id){
        $enfant=Enfant::find($id);
        if (!$enfant) {
            return   response()->json(['message'=>'enfant Not Found'],404);
        }
        $enfant->delete();
        return response()->json(['message'=>'enfant deleted'],200);
    }
}
