<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;
use App\Http\Requests\MatiereStoreRequest;

class MatiereController extends Controller
{
    //
    public function index(){
        $matiere = Matiere::all();
        return    response()->json(["data"=>$matiere], 200);
    }

public function show($id){
       
        $matiere= Matiere::find($id);
     //    dd($matiere);
        if(!$matiere){
         return  response()->json(['message'=>'matiere not found'],404);
        }else{
         return  response()->json(["data"=>$matiere],200);
        }
 }
 public function store(MatiereStoreRequest $request){
    //  $generated_password = generatePassword();
     // dd($request->input($generated_password));
     $azerty="azerty";
      Matiere::create([
          'codematiere'=>$request->input('codematiere'),
          'nommatiere'=>$request->input('nommatiere'),
      ]);
      return response()->json(['message'=>'Create Matiere success'],200);
  }
  public function update(Request $request, $id){
    $matiere= Matiere::find($id);
       if (!$matiere) {
          return response()->json(['message'=>"Not Found"],404);
       }
       $matiere ->update([
         'codematiere'=>$request->input('codematiere',$matiere->codematiere),
         'nommatiere'=>$request->input('nommatiere',$matiere->nommatiere),
         
       ]);
       return response()->json(['message'=>'Update Successfully'],200);
    }
    public function destroy($id){
        $matiere=Matiere::find($id);
        if (!$matiere) {
            return   response()->json(['message'=>'matiere Not Found'],200);
        }

        $matiere->Enseignant()->detach();
        $matiere->delete();
        return response()->json(['message'=>'matiere deleted'],200);
    }
}
