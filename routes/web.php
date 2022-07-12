<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\NotificationToEmailController;
use App\Http\Controllers\TestNoteficaionPucherController;
use App\Mail\AlertMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/*Route::get('/email', function () {
    Mail::to('hasan.sarm.syria.h.s@gmail.com')->send(new AlertMail());
    return new AlertMail();

});*/
Route::get('/email',[NotificationToEmailController::class,'notifyemail']);
Route::get('/notify',[TestNoteficaionPucherController::class,'notifypusher']);

