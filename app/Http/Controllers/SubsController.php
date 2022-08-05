<?php

namespace App\Http\Controllers;

use App\Models\Sub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubsController extends Controller
{
   public function addSubs(Request $request)
   {
    $validator =Validator::make($request->all(),[
        'sub_name'=>'required',

        'next_payment'=>'required|date',
        'amount'=>'required',



    ]);
    if ($validator->fails())
    {
        return response()->json($validator->errors()->toJson(),400);
    }
    $user_id= Auth::guard('api')->user()->id;
    $input2['sub_name'] = $request->sub_name;
    $input2['category_id'] = 2;
    $input2['next_payment']=$request->next_payment;
    $input2['amount']=$request->amount;
    $input2['user_id']=$user_id;
    $input2['bill_id']=2;
    $sub = Sub::create($input2);
    return response()->json([
        'messege'=> 'Subscribe add seccesfuly ',
        'subscribe'=>$sub,
]);


   }
   public function yoursub()
   {
    $user_id= Auth::guard('api')->user()->id;
    $sub=Sub::whereHas('user',function($q) use ($user_id) {
        $q->where('user_id',$user_id);
        })->get();
        return response()->json([
            'subscribes'=>$sub,
        ]);
   }
   public function removesub(Request $request)
   {
    $id = $request->id;
    $user_id= Auth::guard('api')->user()->id;
    $sub= Sub::find($id);
    if ($sub->user_id == $user_id)
    {
        $sub->delete();
        return response()->json(['massege'=>'subscribe deleted seccesfuly']);
    }

    return response()->json(['massege'=>'Sorry you cant do that this is not your subscribe']);
   }
}
