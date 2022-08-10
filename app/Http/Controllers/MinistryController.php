<?php

namespace App\Http\Controllers;

use App\Models\BankAccounte;
use App\Models\Communication;
use App\Models\Electric;
use App\Models\Sub;
use App\Models\Transe;
use App\Models\Water;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


//Controller to make it easer for Frontend
class MinistryController extends Controller
{
    // Search
   public function search(Request $request)
   {
    $Ministry_id=$request->Ministry_id;
    if($Ministry_id==1)
    {
        $city_code= $request -> city_code ;
        $number=$request -> code ;
      $bill = Communication::whereHas('city',
        function ($q) use ($number,$city_code) {
             $q->where('city_code',$city_code);
             $q->where('number',$number);
             })->get();
             if ( $bill ->isEmpty()) {
                return response()->json(['messege'=> 'Bill not found ']);
            }
            return response()->json([$bill]);

    }
    elseif($Ministry_id==2)
    {
        $city_code= $request -> city_code ;
        $code=$request -> code ;
        $bill = Water::whereHas('city', function ($q) use ($code,$city_code) {
             $q->where('city_code',$city_code);
             $q->where('code',$code);
             })->get();
             if ( $bill ->isEmpty()) {
                return response()->json(['messege'=> 'bill not found ']);
            }
            return response()->json([$bill]);

    }
    elseif($Ministry_id==3)
    {
        $city_code= $request -> city_code ;
        $code=$request -> code ;
        $bill = Electric::whereHas('city', function ($q) use ($code,$city_code) {
             $q->where('city_code',$city_code);
             $q->where('code',$code);
             })->get();
             if ( $bill ->isEmpty()) {
                return response()->json(['messege'=> 'bill not found ']);
            }
            return response()->json([$bill]);

    }
    else
    {
        return response()->json(['msg'=>'please select Right Ministry_id 1 for Communication 2 for Water 3 for Electric']);
    }

   }
    /**
     * Pay a bill by Id
     */
    public function PaySearch(Request $request)
    {
    $Ministry_id=$request->Ministry_id;
    if($Ministry_id==1)
    {
        $id= $request -> id ;
        $bill = Communication::where('pay_state',0)->find($id);
        if (is_null($bill)) {
            return response()->json(['messege'=> 'bill not found or payed']);
        }

        $amount = $bill->amount;
        $pay_state= $bill->pay_state;
        $user_id= Auth::guard('api')->user()->id;
        $card_number= Auth::guard('api')->user()->card_number;
         $bankaccount = BankAccounte::where('card_number', $card_number)->first();
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
            $input['user_id']=$user_id;
            $transe=Transe::create($input);
            //subscrite info
            $input2['sub_name'] = 'communication';
            $input2['category_id'] = '1';
            $input2['next_payment']=$bill->next_payment;
            $input2['amount']=$bill->amount;
            $input2['user_id']=$user_id;
            $input2['bill_id']=$bill->id;
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
    elseif($Ministry_id==2)
    {
        $id= $request -> id ;
        $bill = Water::where('pay_state',0)->find($id);
        if (is_null($bill)) {
            return response()->json(['messege'=> 'bill not found or payed']);
        }

        $amount = $bill->amount;
        $pay_state= $bill->pay_state;
        $user_id= Auth::guard('api')->user()->id;
        $card_number= Auth::guard('api')->user()->card_number;
         $bankaccount = BankAccounte::where('card_number', $card_number)->first();
         $Water_ministry_account = BankAccounte::where('user_name','=','Water Ministry')->first();
       if ($amount<= $bankaccount->amount && $pay_state == 0)
        {
            $bankaccount->amount -= $amount ;
            $bill->pay_state = 1;
            $Water_ministry_account->amount+=$amount;
            //transformation info
            $input['Transe_name']='Water';
            $input['from']=$bankaccount->user_name;
            $input['to']='Water Ministry';
            $input['transe_amount']=$bill->amount;
            $input['bill_id']=$bill->id;
            $input['user_id']=$user_id;
            $transe=Transe::create($input);
            //subscrite info
            $input2['sub_name'] = 'water';
            $input2['category_id'] = '1';
            $input2['next_payment']=$bill->next_payment;
            $input2['amount']=$bill->amount;
            $input2['user_id']=$user_id;
            $input2['bill_id']=$bill->id;
            $sub = Sub::create($input2);
            $bill->save();
            $bankaccount->save();
            $Water_ministry_account->save();
            return response()->json([
                'messege'=> 'payed seccesfuly ',
                'your cashe is' =>$bankaccount->amount,
                'trans info'=>$transe,
                'new subscribe'=>$sub,
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
    elseif($Ministry_id==3)
    {
        $id= $request -> id ;
        $bill = Electric::where('pay_state',0)->find($id);
        if (is_null($bill)) {
            return response()->json(['messege'=> 'bill not found or payed']);
        }

        $amount = $bill->amount;
        $pay_state= $bill->pay_state;
        $user_id= Auth::guard('api')->user()->id;
        $card_number= Auth::guard('api')->user()->card_number;
         $bankaccount = BankAccounte::where('card_number', $card_number)->first();
         $Electric_ministry_account = BankAccounte::where('user_name','=','Electric Ministry')->first();
       if ($amount<= $bankaccount->amount && $pay_state == 0)
        {
            $bankaccount->amount -= $amount ;
            $bill->pay_state = 1;
            $Electric_ministry_account->amount+=$amount;
            //transformation info
            $input['Transe_name']='Electric';
            $input['from']=$bankaccount->user_name;
            $input['to']='Electric Ministry';
            $input['transe_amount']=$bill->amount;
            $input['bill_id']=$bill->id;
            $input['user_id']=$user_id;
            $transe=Transe::create($input);
            //subscrite info
            $input2['sub_name'] = 'electric';
            $input2['category_id'] = '1';
            $input2['next_payment']=$bill->next_payment;
            $input2['amount']=$bill->amount;
            $input2['user_id']=$user_id;
            $input2['bill_id']=$bill->id;
            $sub = Sub::create($input2);
            $bill->save();
            $bankaccount->save();
            $Electric_ministry_account->save();
            return response()->json([
                'messege'=> 'payed seccesfuly ',
                'your cashe is' =>$bankaccount->amount,
                'trans info'=>$transe,
                'new subscribe'=>$sub,
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
        return response()->json(['msg'=>'please select Right Ministry_id \n 1 for Communication \n 2 for Water \n 3 for Electric']);
    }

    }
    /**
     * payed Bill
     */
    public function searchPayed(Request $request)
    {
        $Ministry_id=$request->Ministry_id;
        if($Ministry_id==1)
        {
            $city_code= $request -> city_code ;
            $number=$request -> code ;
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
        elseif($Ministry_id==2)
        {
            $city_code= $request -> city_code ;
            $code=$request -> code ;
            $bill = Water::whereHas('city',
            function ($q) use ($code,$city_code) {
                 $q->where('city_code',$city_code);
                 $q->where('code',$code);
                 $q->where('pay_state',1);
                 })->get();
                 if ( $bill ->isEmpty()) {
                    return response()->json(['messege'=> 'there is no payed Billes ']);
                }
                return response()->json([$bill]);

        }
        elseif($Ministry_id==3)
        {
        $city_code= $request -> city_code ;
        $code=$request -> code ;
        $bill = Electric::whereHas('city',
        function ($q) use ($code,$city_code) {
             $q->where('city_code',$city_code);
             $q->where('code',$code);
             $q->where('pay_state',1);
             })->get();
             if ( $bill ->isEmpty()) {
                return response()->json(['messege'=> 'there is no payed Billes ']);
            }
            return response()->json([$bill]);

        }
        else
        {
            return response()->json(['msg'=>'please select Right Ministry_id \n 1 for Communication \n 2 for Water \n 3 for Electric']);
        }

    }
    /**
     * unpayed Bill
     */
    public function searchUnPayed(Request $request)
    {
        $Ministry_id=$request->Ministry_id;
        if($Ministry_id==1)
        {
            $city_code= $request -> city_code ;
            $number=$request -> code ;
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
        elseif($Ministry_id==2)
        {
            $city_code= $request -> city_code ;
            $code=$request -> code ;
            $bill = Water::whereHas('city',
              function ($q) use ($code,$city_code) {
                   $q->where('city_code',$city_code);
                   $q->where('code',$code);
                   $q->where('pay_state',0);
                   })->get();
                   if ( $bill ->isEmpty()) {
                      return response()->json(['messege'=> 'there is no unpayed Billes ']);
                  }
                  return response()->json([$bill]);

        }
        elseif($Ministry_id==3)
        {
      $city_code= $request -> city_code ;
      $code=$request -> code ;
      $bill = Electric::whereHas('city',
        function ($q) use ($code,$city_code) {
             $q->where('city_code',$city_code);
             $q->where('code',$code);
             $q->where('pay_state',0);
             })->get();
             if ( $bill ->isEmpty()) {
                return response()->json(['messege'=> 'there is no unpayed Billes ']);
            }
            return response()->json([$bill]);

        }
        else
        {
            return response()->json(['msg'=>'please select Right Ministry_id \n 1 for Communication \n 2 for Water \n 3 for Electric']);
        }
    }


}
