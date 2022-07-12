<?php

namespace App\Http\Controllers;


use App\Models\SuperAdmin;
use App\Notifications\RealTimeMassegeNotification;
use Illuminate\Http\Request;
use App\Events\SendNotificationEvent;

class TestNoteficaionPucherController extends Controller
{
    public function notifypusher()
    {
       $user = SuperAdmin::first();
       $email = $user->email;
       $id=$user->id;
       $data = [
           'id'=>$id,
           'email'=>$email,
           'massege'=>'new bill'
       ];

       $user->notify(new RealTimeMassegeNotification('Hi '.$user->name.' you have new bill'));
       event(new SendNotificationEvent($data));
       return 'Notification sent';
    }
}
