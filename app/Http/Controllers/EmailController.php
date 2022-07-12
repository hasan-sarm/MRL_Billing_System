<?php

namespace App\Http\Controllers;

use App\Mail\AlertAtechmentMail;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function email(Request $request){
        $users =$request->email;
      //  mail($user,'api','hello');
         Mail::to($users)->send(new AlertAtechmentMail());
       return response()->json(['email send succfully','user'=>$users]);
    }
}
