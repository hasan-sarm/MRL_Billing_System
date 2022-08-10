<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthSuperAdminController extends Controller
{
    protected $db_mysql;
    public function __construct()
    {
        $this ->db_mysql= config('database.connections.mysql.database');
    // $this->middleware('AsignGaurd:super_admin-api',['except'=>['login']]);
    }
    /**
     * Login
     */
    public function superlog(Request $request)
    {
     $validator =Validator::make($request->all(),[

         'email'=>'required|string|email',
         'password'=>'required|string|min:8',
     ]);
     if ($validator->fails())
     {
         return response()->json($validator->errors()->toJson(),422);
     }
     $credentials=$request->only(['email','password']);

     if(!$token=auth()->guard('super_admin-api')->attempt($credentials))
     {
       return response()->json(['error'=>'Unauthorized'],401);
     }
     //return $this->respondWihtToken($token);

     return response()->json([
         'access_token'=>$token,
         'user'=>auth()->guard('super_admin-api')->user(),

       ]);

    }
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
