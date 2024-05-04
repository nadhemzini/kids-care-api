<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReclamationStoreRequest;
use App\Models\Reclamation;
use Illuminate\Http\Request;

class ReclamationController extends Controller
{
    public function reclamation($parentid)
{
    $reclamation = Reclamation::whereHas('parents', function ($query) use ($parentid) {
        $query->where('parent_id', $parentid);
    })->orderBy('created_at', 'desc')->get();

    return response()->json(["data" => $reclamation], 200);
}
    public function index(){
        // $reclamation = Reclamation::orderBy('created_at','desc')->with('Parents');
        $reclamation = Reclamation::orderBy('created_at','desc')->with('Parents')->get();
        return    response()->json(["data"=>$reclamation], 200);
    } 

    public function show($id){
       
        $reclamation= Reclamation::find($id);
     //    dd($reclamation);
        if(!$reclamation){
         return  response()->json(['message'=>'reclamation not found'],404);
        }else{
         return  response()->json(["data"=>$reclamation],200);
        }
 }

 public function store(ReclamationStoreRequest $request){

      Reclamation::create([
          'title'=>$request->input('title'),
          'description'=>$request->input('description'),
          'response'=>$request->input('response'),
          'parent_id'=>$request->input('parent_id'),

      ]);
      return response()->json(['message'=>'Create Reclamation success'],200);
  }

  public function update(Request $request, $id){
    $reclamation= Reclamation::find($id);
       if (!$reclamation) {
          return response()->json(['message'=>"Not Found"],404);
       }
       $request->validate([
        'response' => 'string|min:5',
    ]);
       $reclamation ->update([
         'statue'=>true,
         'response'=>$request->input('response',$reclamation->response),
       ]);
       return response()->json(['message'=>'Update Successfully'],200);
    }

    public function destroy($id){
        $reclamation=Reclamation::find($id);
        if (!$reclamation) {
            return   response()->json(['message'=>'reclamation Not Found'],200);
        }
        $reclamation->delete();
        return response()->json(['message'=>'reclamation deleted'],200);
    }
}
