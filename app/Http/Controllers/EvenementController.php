<?php

namespace App\Http\Controllers;

use App\Http\Requests\EvenementstoreRequest;
use App\Models\Evenement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evenement = Evenement::all();
       return response()->json(["data" => $evenement]);
    }

    public function show($id)
    {
        $evenemet = Evenement::find($id);
        if (!$evenemet) {
            return response()->json(["message"=>"evenement not found"],404);
        }
        return response()->json(["data"=>$evenemet],200);
    }
   
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    
    {
        // dd($request);
        try {
            // dd($request); // Check if the request object is being dumped
            $start = Carbon::parse($request->input('start'));
            $end = Carbon::parse($request->input('end'));
            // dd($end);
            Evenement::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'), // Assuming this is correct
                'start' => $start,
                'end' => $end,
            ]);
            return response()->json(['message' => 'Create Evenement success'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

   
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $evenement= Evenement::find($id);
       if (!$evenement) {
          return response()->json(['message'=>"Not Found"],404);
       }
       $start = Carbon::parse($request->input('start'));
            $end = Carbon::parse($request->input('end'));
       $evenement ->update([
         'title'=>$request->input('title',$evenement->title),
         'description'=>$request->input('description',$evenement->description),
         'start' => $start,
         'end' => $end,
       ]);
       return response()->json(['message'=>'Update Successfully'],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $evenement= Evenement::find($id);
        if (!$evenement) {
           return response()->json(['message'=>"Not Found"],404);
        }
        $evenement->delete();
        return response()->json(['message'=>'Delete Successfully'],200); 
    }
}
