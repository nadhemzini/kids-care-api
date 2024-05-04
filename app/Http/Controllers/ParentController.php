<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParentStoreRequest;
use App\Mail\mailer;
use Illuminate\Support\Facades\Mail;
use App\Models\Parents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class ParentController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('parents')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $parent = Auth::guard('parents')->user();
        $token = JWTAuth::fromUser($parent);

        return response()->json([
            'parent' => $parent,
            'token' => $token
        ], 200);
    }
    public function index(){
        $parent = Parents::all();
        return    response()->json(["data"=>$parent], 200);
    } 

    public function show($id){
       
        $parent= Parents::find($id);
        
     //    dd($parent);
        if(!$parent){
         return  response()->json(['message'=>'parent not found'],404);
        }else{
         return  response()->json(["data"=>$parent],200);
        }
 }
 public function store(ParentStoreRequest $request){ 
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
     $generated_password = generatePassword();
    if ($request->has('image')) {
        $image=$request->file('image');
        $name=time(). '.' .$image->getClientOriginalExtension();
        $image->move('images/',$name);
    }
    
      $parent= Parents::create([
          'fullname'=>$request->input('fullname'),
          'image'=>$name,
          'cin'=>$request->input('cin'),
          'telephone'=>$request->input('telephone'),
          'email'=>$request->input('email'),
          'ville'=>$request->input('ville'),
          'gender'=>$request->input('gender'),
          'codepostal'=>$request->input('codepostal'),
          'password' => Hash::make($generated_password),
      ]);
      Mail::to($parent->email)->send(new mailer($parent->fullname, $generated_password));
     
      return response()->json(['message'=>'Create Parent success'],200);
  }
  public function update(Request $request, $id){
    $parent= Parents::find($id);
       if (!$parent) {
          return response()->json(['message'=>"Not Found"],404);
       }
      //   
       $parent ->update([
         'fullname'=>$request->input('fullname',$parent->fullname),
         'image'=>$request->input('image',$parent->image),
         'cin'=>$request->input('cin',$parent->cin),
         'telephone'=>$request->input('telephone',$parent->telephone),
         'ville'=>$request->input('ville',$parent->ville),
         'codepostal'=>$request->input('codepostal',$parent->codepostal),
         'gender'=>$request->input('gender',$parent->gender),
         'email'=>$request->input('email')
       ]);
       return response()->json(['message'=>'Update Successfully'],200);
    }
    public function destroy($id){
        $parent=Parents::find($id);
        if (!$parent) {
         return   response()->json(['message'=>'parent Not Found'],404);
        }
        $parent->delete();
        return response()->json(['message'=>'parent deleted'],200);
    }
}
