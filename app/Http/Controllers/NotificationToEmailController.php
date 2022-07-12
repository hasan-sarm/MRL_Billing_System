<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use App\Notifications\AlertEnrollment;
use Illuminate\Http\Request;

class NotificationToEmailController extends Controller
{
    public function notifyemail()
    {
        $user = SuperAdmin::first();
        $data=[
            'name'=>$user->name,
            'message'=>'you have new bill'
        ];
        $user->notify(new AlertEnrollment($data));
    }
}
