<?php

namespace App\Http\Controllers;

use App\Models\BankAccounte;
use App\Models\Cenimacity;
use App\Models\Sub;
use App\Models\Transe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CenimacityController extends Controller
{
    public function search(Request $request)
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
    /**
     * Pay a bill by Id
     */
    public function save(Request $request)
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


    public function PaySearch(Request $request)
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
    /**
     * payed Bill
     */
    public function searchPayed(Request $request)
    {
        $code= $request -> code ;

        $bill = Cenimacity::where(function ($q) use ($code) {
             $q->where('code',$code);

             $q->where('pay_state',1);
             })->get();
             if ( $bill ->isEmpty()) {
                return response()->json(['messege'=> 'there is no payed Billes ']);
            }
            return response()->json([$bill]);
    }
    /**
     * unpayed Bill
     */
    public function searchUnPayed(Request $request)
    {
        $code= $request -> code ;

      $bill = Cenimacity::where(
        function ($q) use ($code) {
             $q->where('code',$code);

             $q->where('pay_state',0);
             })->get();
             if ( $bill ->isEmpty()) {
                return response()->json(['messege'=> 'there is no unpayed Billes ']);
            }
            return response()->json([$bill]);
    }
}
