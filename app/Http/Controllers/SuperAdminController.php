<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\BankAccounte;
use App\Models\Sub;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

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
        if ($user == null)
        {
            return response()->json(['msg'=>'ther is no user in this id']);
        }
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

    // get user subscribes
    public function getSubs(Request $request)
    {
        $user_id= $request->user_id;
        $subs = Sub::whereHas('user', function ($q) use ($user_id) {
            $q->where('user_id',$user_id);

            })->get();



        if($subs == null){
            return response()->json(['Subscrubes'=>'no subs for this user']);

        }
        return response()->json(['Subscrubes'=>$subs]);
    }
    public function adduser(Request $request)
    {
        $validator =Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8',
            'card_number'=>'required|exists:mysql_bank.bank_accountes',
            'cvc'=>'required|exists:mysql_bank.bank_accountes',
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors()->toJson(),400);
        }
        $user=User::create(array_merge(
            $validator->validated(),
            ['password'=>bcrypt($request->password)]
        ));
        $banckAccount= BankAccounte::where('card_number',$request->card_number)->first();
        $banckAccount->user_id = $user->id;
        $banckAccount->save();

        return response()->json([
            'message'=>'user added successfully',

        ],201);
    }


}
