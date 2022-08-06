<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function profile()
    {
        $user= Auth::guard('api')->user();
        return response()->json(['user'=>$user]);
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $id = Auth::guard('api')->user()->id;
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
        $user->password=  Hash::make($input['password'])  ;
        }
        if($request->exists('card_number')){
        $user->card_numbe=  $input['card_number'] ;
        }
        if($request->exists('cvc')){
            $user->cvc= $input['cvc'] ;
        }

        $user->save();
        return response()->json(['user'=>$user,'msg'=>'user update succefully']);

    }
}
