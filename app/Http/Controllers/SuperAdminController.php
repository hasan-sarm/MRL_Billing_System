<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Sub;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class SuperAdminController extends Controller
{


    protected $db_mysql;
    public function __construct()
    {
        $this ->db_mysql= config('database.connections.mysql.database');

    }
    // Create new Admin
    public function NewAdmin( Request $request)
    {
        $validator =Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|string|email|unique:admins',
            'password'=>'required|min:8',
            'Ministry'=>'required',

        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors()->toJson(),400);
        }
        $user=Admin::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]
        ));
        $credentials=$request->only(['email','password']);
        $token=auth()->guard('admin-api')->attempt($credentials);
        return response()->json([
            'message'=>'Admin added successfully',

        ],201);
    }
    public function update(Request $request)
    {

        $input = $request->all();
        $id = $request->id;
        $user = User::find($id);
        $validator = validator($input, [
            'name'=>'string',
            'email'=>'string|email|unique:users',
            'password'=>'min:8',
            'card_number'=>'exists:mysql_bank.bank_accountes',
            'cvc'=>'exists:mysql_bank.bank_accountes',


        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()]);
        }

        if($request->exists('name')){
        $user->name= $input['name'] ;
        }
        if($request->exists('email')){
        $user->email= $input['email'] ;
        }
        if($request->exists('password')){
        $user->password= $input['password'] ;
        }
        if($request->exists('card_number')){
        $user->card_numbe= $input['card_number'] ;
        }
        if($request->exists('cvc')){
            $user->cvc= $input['cvc'] ;
        }

        $user->save();
        return response()->json(['user'=>$user,'msg'=>'user update succefully']);
    }
    public function getSubs(Request $request)
    {
        $id= $request->id;
        $subs = Sub::where('user_id',$id)->get();
      /*  if(isEmpty($subs)){
            return response()->json(['Subscrubes'=>'no subs for this user']);

        }*/
        return response()->json(['Subscrubes'=>$subs]);
    }
}
