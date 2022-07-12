<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\SendNotificationEvent;
use App\Models\SuperAdmin;


class NotificationController extends Controller
{

    public function notification(){
    $user = SuperAdmin::first();
    $email = $user->email;
    $id=$user->id;
    $data = [
        'id'=>$id,
        'email'=>$email,
        'massege'=>'new bill'
    ];
   event(new SendNotificationEvent($data));
}
}
