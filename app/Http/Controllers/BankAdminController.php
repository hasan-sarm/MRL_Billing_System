<?php

namespace App\Http\Controllers;

use App\Models\BankAccounte;
use App\Models\Transe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class BankAdminController extends Controller
{
   public function transinfo(Request $request)
   {
    $admin_id = Auth::guard('admin-api')->user()->Ministry;
    if ($admin_id==4)
    {
    $card_number= $request->card_number;
    $cvc= $request->cvc;
    $user= BankAccounte::where(function($q) use ($card_number,$cvc){
        $q->where('card_number',$card_number);
        $q->where('cvc',$cvc);
    })->first();
    $user_id=$user->user_id;
    $trans= Transe::where(function($q) use ($user_id){
        $q->where('user_id',$user_id);
    })->get();
    return response()->json(['trans'=>$trans]);
   }
   else{
    return response()->json(['error'=>'Unathorized'],401);
   }
   }

   public function addacc(Request $request)
   {
    $admin_id = Auth::guard('admin-api')->user()->Ministry;
    if($admin_id==4){
    $validator =Validator::make($request->all(),[

        'user_name'=>'required|string',
        'card_number'=>'required|string|unique:mysql_bank.Bank_accountes,card_number',
        'cvc'=>'required|integer|unique:mysql_bank.Bank_accountes,cvc',
        'amount'=>'required'
    ]);
    if ($validator->fails())
    {
        return response()->json($validator->errors()->toJson(),422);
    }
    $input['user_name']=$request->user_name;
    $input['card_number']=$request->card_number;
    $input['cvc']=$request->cvc;
    $input['amount']=$request->amount;

    $account=BankAccounte::create(
        $input
    );
    return response()->json(['msg'=>'add succfully','Account'=>$account]);
   }
   else{
    return response()->json(['error'=>'Unathorized'],401);
   }
   }
   public function deleteacc(Request $request)
   {
    $admin_id = Auth::guard('admin-api')->user()->Ministry;
    if($admin_id==4){
        $card_number= $request->card_number;
        $cvc= $request->cvc;
        $account=BankAccounte::where(function($q) use ($card_number,$cvc){
            $q->where('card_number',$card_number);
            $q->where('cvc',$cvc);
        })->first();
        if ( $account== null) {
                return response()->json(['messege'=> 'there is no account by this card number and cvc ']);
            }
            $account->delete();
        return response()->json(['massege'=>'Account deleted seccesfuly']);
    }
    else{
        return response()->json(['error'=>'Unathorized'],401);
       }

   }

}
