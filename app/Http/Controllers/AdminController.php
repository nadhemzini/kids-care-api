<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\mailer;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;





class AdminController extends Controller
{
    
    
    //





    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('admins')->attempt($credentials)) {
            return response()->json(['error' => 'ok'], 401);
        }

        $admin = Auth::guard('admins')->user();
        $token = JWTAuth::fromUser($admin);

        return response()->json([
            'admin' => $admin,
            'token' => $token
        ], 200);
    }
    public function me()
    {
        return response()->json(Auth::guard('admins')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

     public function index(){
        $admin = Admin::all();
        return    response()->json(["data"=>$admin], 200);
    } 
    public function show($id)
    {

        $admin = Admin::find($id);
        //    dd($admin);
        if (!$admin) {
            return  response()->json(['message' => 'User not found'], 404);
        } else {
            return  response()->json(["data" => $admin], 200);
        }
    }
    public function store(AdminStoreRequest $request)
    {

        function generatePassword()
    {
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
         

        $admin = Admin::create([
            'fullname' => $request->input('fullname'),
           'image'=>$name,
            'telephone' => $request->input('telephone'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
            'gender' => $request->input('gender'),
            'password' => Hash::make($generated_password),
        ]);
        Mail::to($admin->email)->send(new mailer($admin->fullname, $generated_password));

        return response()->json(['message' => 'Create admin success'], 200);
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['message' => "Not Found"], 404);
        }
        //   dd($request->input());
        $admin->update([
            'fullname' => $request->input('fullname', $admin->fullname),
            'image' => $request->input('image', $admin->image),
            'telephone' => $request->input('telephone', $admin->telephone),
            'role' => $request->input('role', $admin->role),
            'gender' => $request->input('gender', $admin->gender),
            'email' => $request->input('email')
        ]);
        return response()->json(['message' => 'Update Successfully'], 200);
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return  response()->json(['message' => 'admin Not Found'], 200);
        }
        $admin->delete();
        return response()->json(['message' => 'admin deleted'], 200);
    }
}
