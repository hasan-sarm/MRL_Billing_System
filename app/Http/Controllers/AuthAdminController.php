<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthAdminController extends Controller
{
    protected $db_mysql;
    public function __construct()
    {
        $this ->db_mysql= config('database.connections.mysql.database');
    // $this->middleware('AsignGaurd:admin-api',['except'=>['login']]);
    }


    /**
     * Register
     */

    /**
     * Login
     */
    public function login(Request $request)
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

        if(!$token=auth()->guard('admin-api')->attempt($credentials))
        {
          return response()->json(['error'=>'Unathorized'],401);
        }
        //return $this->respondWihtToken($token);

        return response()->json([
            'access_token'=>$token,
            'user'=>auth()->guard('admin-api')->user(),

          ]);



    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
   /* public function me()
    {
        return response()->json(auth()->user());
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
   /* public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
   /* protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
    */
}
