<?php

namespace App\Http\Controllers;

use App\Models\BankAccounte;
use App\Models\Cenimacity;
use App\Models\Sahara;
use App\Models\Sub;
use App\Models\Transe;
use App\Models\Vip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Controller for Specail subscribes to make it easer for Frontend
class SpecialController extends Controller
{
    //search for bill
    public function search(Request $request)
    {
        $special_id = $request->special_id;
        if($special_id == 1)
        {
            $code=$request -> code ;
            $bill = Sahara::where( function ($q) use ($code) {
                 $q->where('code',$code);

                 })->get();
                 if ( $bill ->isEmpty()) {
                    return response()->json(['messege'=> 'bill not found ']);
                }
                return response()->json([$bill]);


        }
        elseif($special_id==2)
        {
            $code=$request -> code ;
            $bill = Cenimacity::where( function ($q) use ($code) {
                 $q->where('code',$code);

                 })->get();
                 if ( $bill ->isEmpty()) {
                    return response()->json(['messege'=> 'bill not found ']);
                }
                return response()->json([$bill]);
        }
        elseif($special_id==3)
        {
         $code=$request -> code ;
        $bill = Vip::where( function ($q) use ($code) {
             $q->where('code',$code);

             })->get();
             if ( $bill ->isEmpty()) {
                return response()->json(['messege'=> 'bill not found ']);
            }
            return response()->json([$bill]);


        }
        else
        {
            return response()->json(['msg'=>'please select the Right special id 1 for Sahara pool 2 for Cinema City 3 for Vip gym']);
        }
    }

    // save a sub
    public function save(Request $request)
    {
        $special_id = $request->special_id;
        if($special_id == 1)
        {
            $user_id= Auth::guard('api')->user()->id;
            $input2['sub_name'] = 'Sahara pool';
            $input2['category_id'] = '2';
            $input2['next_payment']=$request->next_payment;
            $input2['amount']=$request->amount;
            $input2['user_id']=$user_id;
            $input2['bill_id']=$request->id;
            $sub = Sub::create($input2);
            return response()->json(['messege'=> $sub]);

        }
        elseif($special_id==2)
        {
            $user_id= Auth::guard('api')->user()->id;
            $input2['sub_name'] = 'Cenima city';
            $input2['category_id'] = '2';
            $input2['next_payment']=$request->next_payment;
            $input2['amount']=$request->amount;
            $input2['user_id']=$user_id;
            $input2['bill_id']=$request->id;
            $sub = Sub::create($input2);
            return response()->json(['messege'=> $sub]);

        }
        elseif($special_id==3)
        {
            $user_id= Auth::guard('api')->user()->id;
            $input2['sub_name'] = 'Vip gym';
            $input2['category_id'] = '2';
            $input2['next_payment']=$request->next_payment;
            $input2['amount']=$request->amount;
            $input2['user_id']=$user_id;
            $input2['bill_id']=$request->id;
            $sub = Sub::create($input2);
            return response()->json(['messege'=> $sub]);
        }
        else
        {
            return response()->json(['msg'=>'please select the Right special id 1 for Sahara pool 2 for Cinema City 3 for Vip gym']);
        }
    }
    /**
     * Pay a bill by Id
     */
    public function PaySearch(Request $request)
    {
        $special_id = $request->special_id;
        if($special_id == 1)
        {
            $id= $request -> id ;
            $bill = Sahara::where('pay_state',0)->find($id);
            if (is_null($bill)) {
                return response()->json(['messege'=> 'bill not found or payed']);
            }

            $amount = $bill->amount;
            $pay_state= $bill->pay_state;
            $user_id= Auth::guard('api')->user()->id;
            $card_number= Auth::guard('api')->user()->card_number;
             $bankaccount = BankAccounte::where('card_number', $card_number)->first();
             $sahara_account = BankAccounte::where('user_name','=','Sahara')->first();
           if ($amount<= $bankaccount->amount && $pay_state == 0)
            {
                $bankaccount->amount -= $amount ;
                $bill->pay_state = 1;
                $sahara_account->amount+=$amount;
                //transformation info
                $input['Transe_name']='Sahara';
                $input['from']=$bankaccount->user_name;
                $input['to']='Sahara';
                $input['transe_amount']=$bill->amount;
                $input['bill_id']=$bill->id;
                $input['user_id']=$user_id;
                $transe=Transe::create($input);

                $bill->save();
                $bankaccount->save();
                $sahara_account->save();
                return response()->json([
                    'messege'=> 'payed seccesfuly ',
                    'your cashe is' =>$bankaccount->amount,
                    'trans info'=>$transe,

            ]);
            }
            else
            {
                if($pay_state == 1)
                {
                    return response()->json(['messege'=> 'sorry allredy payed']);
                }
                if ($amount>= $bankaccount->amount)
                {
                return response()->json(['messege'=> 'sorry you dont have many ']);
                }
            }

        }
        elseif($special_id==2)
        {
        $id= $request -> id ;
        $bill = Cenimacity::where('pay_state',0)->find($id);
        if (is_null($bill)) {
            return response()->json(['messege'=> 'bill not found or payed']);
        }

        $amount = $bill->amount;
        $pay_state= $bill->pay_state;
        $user_id= Auth::guard('api')->user()->id;
        $card_number= Auth::guard('api')->user()->card_number;
         $bankaccount = BankAccounte::where('card_number', $card_number)->first();
         $cenima_city_account = BankAccounte::where('user_name','=','Cenima city')->first();
       if ($amount<= $bankaccount->amount && $pay_state == 0)
        {
            $bankaccount->amount -= $amount ;
            $bill->pay_state = 1;
            $cenima_city_account->amount+=$amount;
            //transformation info
            $input['Transe_name']='Cenima city';
            $input['from']=$bankaccount->user_name;
            $input['to']='Cenima city';
            $input['transe_amount']=$bill->amount;
            $input['bill_id']=$bill->id;
            $input['user_id']=$user_id;
            $transe=Transe::create($input);


            $bill->save();
            $bankaccount->save();
            $cenima_city_account->save();
            return response()->json([
                'messege'=> 'payed seccesfuly ',
                'your cashe is' =>$bankaccount->amount,
                'trans info'=>$transe,

        ]);
        }
        else
        {
            if($pay_state == 1)
            {
                return response()->json(['messege'=> 'sorry allredy payed']);
            }
            if ($amount>= $bankaccount->amount)
            {
            return response()->json(['messege'=> 'sorry you dont have many ']);
            }
        }

        }
        elseif($special_id==3)
        {
        $id= $request -> id ;
        $bill = vip::where('pay_state',0)->find($id);
        if (is_null($bill)) {
            return response()->json(['messege'=> 'bill not found or payed']);
        }

        $amount = $bill->amount;
        $pay_state= $bill->pay_state;
        $user_id= Auth::guard('api')->user()->id;
        $card_number= Auth::guard('api')->user()->card_number;
         $bankaccount = BankAccounte::where('card_number', $card_number)->first();
         $vip_account = BankAccounte::where('user_name','=','Vip')->first();
       if ($amount<= $bankaccount->amount && $pay_state == 0)
        {
            $bankaccount->amount -= $amount ;
            $bill->pay_state = 1;
            $vip_account->amount+=$amount;
            //transformation info
            $input['Transe_name']='Vip gym';
            $input['from']=$bankaccount->user_name;
            $input['to']='Vip';
            $input['transe_amount']=$bill->amount;
            $input['bill_id']=$bill->id;
            $input['user_id']=$user_id;
            $input2['bill_id']=$bill->id;
            $transe=Transe::create($input);

            $bill->save();
            $bankaccount->save();
            $vip_account->save();
            return response()->json([
                'messege'=> 'payed seccesfuly ',
                'your cashe is' =>$bankaccount->amount,
                'trans info'=>$transe,

        ]);
        }
        else
        {
            if($pay_state == 1)
            {
                return response()->json(['messege'=> 'sorry allredy payed']);
            }
            if ($amount>= $bankaccount->amount)
            {
            return response()->json(['messege'=> 'sorry you dont have many ']);
            }
        }
        }
        else
        {
            return response()->json(['msg'=>'please select the Right special id 1 for Sahara pool 2 for Cinema City 3 for Vip gym']);
        }
    }



}
