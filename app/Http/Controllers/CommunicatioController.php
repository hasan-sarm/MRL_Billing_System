<?php

namespace App\Http\Controllers;

use App\Models\BankAccounte;
use App\Models\CityCode ;
use App\Models\Communication;
use App\Models\Transe;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

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

       if ($amount<= $bankaccount->amount && $pay_state == 0)
        {
            $bankaccount->amount -= $amount ;
            $bill->pay_state = 1;
            //transformation info
            $input['Transe_name']='communication';
            $input['from']=$bankaccount->user_name;
            $input['to']='Communication Ministry';
            $input['transe_amount']=$bill->amount;
            $input['bill_id']=$bill->id;
            $input['user_id']=$bankaccount->id;
            $transe=Transe::create($input);
            $bill->save();
            $bankaccount->save();
            return response()->json([
                'messege'=> 'payed seccesfuly ',
                'your cashe is' =>$bankaccount->amount,
                'trans info'=>$transe,
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
