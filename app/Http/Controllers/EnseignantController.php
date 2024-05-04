<?php

namespace App\Http\Controllers;
use App\Models\Enseignant;
use App\Models\Matiere;
use Illuminate\Http\Request;
use App\Http\Requests\EnseignantStoreRequest;
use Illuminate\Support\Facades\Hash;
use App\Mail\mailer;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;

use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;
class EnseignantController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */

     public function login(Request $request)
     {
         $credentials = $request->only('email', 'password');
 
         if (!Auth::guard('enseignants')->attempt($credentials)) {
             return response()->json(['error' => 'Unauthorized'], 401);
         }
 
         $enseignant = Auth::guard('enseignants')->user();
         $token = JWTAuth::fromUser($enseignant);
 
         return response()->json([
             'enseignant' => $enseignant,
             'token' => $token
         ], 200);
     }
     public function index()
     {
         $enseignant = Enseignant::orderBy('created_at','desc')->with('matieres')->with('classes')->get(); // Eager load the enseignant$enseignant relationship
         return response()->json(["data" => $enseignant], 200);
     }

     public function show($id)
     {
        $enseignant= Enseignant::with('matieres')->with('classes')->find($id);
     //    dd($enseignant);
        if(!$enseignant){
         return  response()->json(['message'=>'ense$enseignant not found'],404);
        }else{
         return  response()->json(["data"=>$enseignant],200);
        }
 }
   
    /**
     * Store a newly created resource in storage.
     */
    public function store(EnseignantStoreRequest $request)
    {
        function generatePassword() {
            // Define characters that can be used in the password
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            // Get the total length of the character set
            $chars_length = strlen($chars);
            // Initialize the password variable
            $password = '';
            // Generate random characters and append them to the password until it reaches the desired length
            for ($i = 0; $i < 10; $i++) {
                $password .= $chars[rand(0, $chars_length - 1)];
            }
            return $password;
        }
        $generated_password=generatePassword();
        if ($request->has('image')) {
            $image=$request->file('image');
            $name=time(). '.' .$image->getClientOriginalExtension();
            $image->move('images/',$name);
        }
         
        $enseignant=Enseignant::create([
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'image'=>$name,
            'telephone' => $request->input('telephone'),  
            'gender' => $request->input('gender'),  
            'password' => Hash::make($generated_password),
            $matiere_ids = $request->input("matiere_ids"),
            $class_ids = $request->input("classes_ids"),
            
        ]);
        Mail::to($enseignant->email)->send(new mailer($enseignant->fullname, $generated_password));

        $enseignant->matieres()->sync($matiere_ids);
        $enseignant->classes()->sync($class_ids);
        return response()->json(['message' => 'Enseignant created successfully'], 201);
        
 }
    
    

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $enseignant=Enseignant::find($id);
        if (!$enseignant) {
            return   response()->json(['message'=>'enseignant Not Found'],200);
        }
        $enseignant->delete();
        return response()->json(['message'=>'enseignant deleted'],200);
    }
    }

