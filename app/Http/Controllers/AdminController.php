<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as ResourcesUser;
use App\Models\Cenimacity;
use App\Models\Communication ;
use App\Models\electric;
use App\Models\Sahara ;
use App\Models\Sub;
use App\Models\User;
use App\Models\Vip;
use App\Models\water;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{

    public function showAllUser(Request $request)
    {
        $admin_id = Auth::guard('admin-api')->user()->Ministry;
        $name=$request->name;
        if ($admin_id == 1)
        {

            $users = User::whereHas('subs',function($q) use ($name){
                $q->where('sub_name','communication');
                $q->whereRaw("name like '%".$name."%'");

            })->get();

            return response()->json([
              'users'=>$users
            ]);

        }
       elseif ($admin_id == 2)
        {
            $user = User::whereHas('subs',function($q) use ($name){
                $q->where('sub_name','electric');
                $q->whereRaw("name like '%".$name."%'");
            })->get();
            return response()->json([
                'users'=>$user
            ]);
        }
        elseif ($admin_id == 3)
        {
            $user = User::whereHas('subs',function($q) use ($name){
                $q->where('sub_name','water');
                $q->whereRaw("name like '%".$name."%'");
            })->get();
            return response()->json([
                'users'=>$user
            ]);
        }
        elseif ($admin_id == 5)
        {
            $user = User::whereHas('subs',function($q) use ($name){
                $q->where('sub_name','Sahara pool');
                $q->whereRaw("name like '%".$name."%'");
            })->get();
            return response()->json([
                'users'=>$user
            ]);
        }
        elseif ($admin_id == 6)
        {
            $user = User::whereHas('subs',function($q) use ($name){
                $q->where('sub_name','Vip gym');
                $q->whereRaw("name like '%".$name."%'");
            })->get();
            return response()->json([
                'users'=>$user
            ]);
        }
        elseif ($admin_id == 7)
        {
            $user = User::whereHas('subs',function($q) use ($name){
                $q->where('sub_name','Cenima city');
                $q->whereRaw("name like '%".$name."%'");
            })->get();
            return response()->json([
                'users'=>$user
            ]);
        }

        else
        {
            return response()->json(['messege'=>'erore','id'=>$admin_id]);
        }


    }
    public function showUserBill(Request $request)

    {
        $id = $request->id;

        $admin_id = Auth::guard('admin-api')->user()->Ministry;
        if ($admin_id == 1)
        {

            $sub = Sub::whereHas('user',function($q) use ($id){
                $q->where('user_id',$id);
                $q->where('sub_name','communication');
            })->get();



            return response()->json([
                'subscribes'=> $sub
            ]);



        }
       elseif ($admin_id == 2)
        {
            $sub = Sub::whereHas('user',function($q) use ($id){
                $q->where('user_id',$id);
                $q->where('sub_name','electric');
            })->get();

            return response()->json([
                'subscribes'=> $sub
            ]);

        }
        elseif ($admin_id == 3)
        {
            $sub = Sub::whereHas('user',function($q) use ($id){
                $q->where('user_id',$id);
                $q->where('sub_name','water');
            })->get();

            return response()->json([
                'subscribes'=> $sub
            ]);
        }
        elseif ($admin_id == 5)
        {
            $sub = Sub::whereHas('user',function($q) use ($id){
                $q->where('user_id',$id);
                $q->where('sub_name','Sahara pool');
            })->get();

            return response()->json([
                'subscribes'=> $sub
            ]);
        }
        elseif ($admin_id == 6)
        {
            $sub = Sub::whereHas('user',function($q) use ($id){
                $q->where('user_id',$id);
                $q->where('sub_name','Vip gym');
            })->get();

            return response()->json([
                'subscribes'=> $sub
            ]);
        }
        elseif ($admin_id == 7)
        {
            $sub = Sub::whereHas('user',function($q) use ($id){
                $q->where('user_id',$id);
                $q->where('sub_name','Cenima city');
            })->get();

            return response()->json([
                'subscribes'=> $sub
            ]);
        }
        else
        {
            return response()->json(['messege'=>'erore','id'=>$admin_id]);
        }

    }
    public function update(Request $request)
    {
        $id = $request->id;

        $admin_id = Auth::guard('admin-api')->user()->Ministry;
        if ($admin_id == 1)
        {
            $comm = Communication::find($id);
            if($comm->pay_state==0)
            {
                $comm->pay_state=1;
            }
            elseif($comm->pay_state==1)
            {
                $comm->pay_state=0;
            }
            $comm->save();

        }
       elseif ($admin_id == 2)
        {
            $comm = electric::find($id);
            if($comm->pay_state==0)
            {
                $comm->pay_state=1;
            }
            elseif($comm->pay_state==1)
            {
                $comm->pay_state=0;
            }
            $comm->save();

        }
        elseif ($admin_id == 3)
        {
            $comm = water::find($id);
            if($comm->pay_state==0)
            {
                $comm->pay_state=1;
            }
            elseif($comm->pay_state==1)
            {
                $comm->pay_state=0;
            }
            $comm->save();

        }
        elseif ($admin_id == 5)
        {
            $comm =Sahara::find($id);
            if($comm->pay_state==0)
            {
                $comm->pay_state=1;
            }
            elseif($comm->pay_state==1)
            {
                $comm->pay_state=0;
            }
            $comm->save();

        }
        elseif ($admin_id == 6)
        {
            $comm =Vip::find($id);
            if($comm->pay_state==0)
            {
                $comm->pay_state=1;
            }
            elseif($comm->pay_state==1)
            {
                $comm->pay_state=0;
            }
            $comm->save();
        }
        elseif ($admin_id == 7)
        {
            $comm =Cenimacity::find($id);
            if($comm->pay_state==0)
            {
                $comm->pay_state=1;
            }
            elseif($comm->pay_state==1)
            {
                $comm->pay_state=0;
            }
            $comm->save();
        }
        else
        {
            return response()->json(['messege'=>'erore','id'=>$admin_id]);
        }

    }
}
