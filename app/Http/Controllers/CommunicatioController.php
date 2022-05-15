<?php

namespace App\Http\Controllers;

use App\Models\BankAccounte;
use App\Models\Communication;
use App\Models\Sub;
use App\Models\Transe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommunicatioController extends Controller
{
    /*
    //search for bill
    */


    public function search(Request $request)
    {
        $city_code= $request -> city_code ;
        $number=$request -> number ;
        $bill = Communication::whereHas('city', function ($q) use ($number,$city_code) {
             $q->where('city_code',$city_code);
             $q->where('number',$number);
             })->get();
             if ( $bill ->isEmpty()) {
                return response()->json(['messege'=> 'bill not found ']);
            }
            return response()->json([$bill]);
        /*  $bills = CityCode::with ('communication')
            ->where('id',$city_code)->get();
            foreach ($bills as $bill)
            {
                 $numbers = $bill-> communication;
                 foreach($numbers as $nemb)
                 {
                     $numberin = $nemb->number;
                     if ($numberin == $number)
                     {
                         echo $nemb;
                     }
                     continue;
                 }

            }*/
            /* foreach($bills as $bill)
             {
                echo  $bill -> communication -> amount;
             }*/

    }
    /**
     * Pay a bill by Id
     */
    public function PaySearch(Request $request)
    {

        $id= $request -> id ;
        $bill = Communication::where('pay_state',0)->find($id);
        if (is_null($bill)) {
            return response()->json(['messege'=> 'bill not found or payed']);
        }

        $amount = $bill->amount;
        $pay_state= $bill->pay_state;
        $user_id= Auth::guard('api')->user()->id;

         $bankaccount = BankAccounte::where('user_id',$user_id)->first();
         $communication_ministry_account = BankAccounte::where('user_name','=','Communication Ministry')->first();
       if ($amount<= $bankaccount->amount && $pay_state == 0)
        {
            $bankaccount->amount -= $amount ;
            $bill->pay_state = 1;
            $communication_ministry_account->amount+=$amount;
            //transformation info
            $input['Transe_name']='communication';
            $input['from']=$bankaccount->user_name;
            $input['to']='Communication Ministry';
            $input['transe_amount']=$bill->amount;
            $input['bill_id']=$bill->id;
            $input['user_id']=$bankaccount->id;
            $transe=Transe::create($input);
            //subscrite info
            $input2['sub_name'] = 'communication';
            $input2['category'] = 'payed subs';
            $input2['next_payment']=$bill->next_payment;
            $input2['amount']=$bill->amount;
            $input2['user_id']=$user_id;
            $sub = Sub::create($input2);
            $bill->save();
            $bankaccount->save();
            $communication_ministry_account->save();
            return response()->json([
                'messege'=> 'payed seccesfuly ',
                'your cashe is' =>$bankaccount->amount,
                'trans info'=>$transe,
                'new subscribe'=>$sub,
        ]);
        }
        else
        {
            return response()->json(['messege'=> 'sorry you dont have many']);
        }




    }
    /**
     * payed Bill
     */
    public function searchPayed(Request $request)
    {
        $city_code= $request -> city_code ;
        $number=$request -> number ;
        $bill = Communication::whereHas('city',
        function ($q) use ($number,$city_code) {
             $q->where('city_code',$city_code);
             $q->where('number',$number);
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
        $city_code= $request -> city_code ;
        $number=$request -> number ;
      $bill = Communication::whereHas('city',
        function ($q) use ($number,$city_code) {
             $q->where('city_code',$city_code);
             $q->where('number',$number);
             $q->where('pay_state',0);
             })->get();
             if ( $bill ->isEmpty()) {
                return response()->json(['messege'=> 'there is no unpayed Billes ']);
            }
            return response()->json([$bill]);
    }


}
