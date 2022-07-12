<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunicatioController;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthSuperAdminController;
use App\Http\Controllers\SuperAdminController;
use App\Mail\AlertMail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/*Route::group(['middleware'=>'api','prefix'=>'auth'],function ($router){
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
});*/
Route::group([

    'middleware' => 'api',


], function ($router) {
    Route::group([ 'prefix' => 'user', ], function ($router) {
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('logout',[AuthController::class,'logout']);
});
    Route::group([ 'prefix' => 'admin', ], function ($router) {
        Route::post('login',[AuthAdminController::class,'login']);
        Route::post('logout',[AuthAdminController::class,'logout']);


    });
    Route::group([ 'prefix' => 'Super_admin' ], function ($router) {
        Route::post('superlog',[App\Http\Controllers\AuthSuperAdminController::class,'superlog'])->name('superlog');
        Route::post('logout',[AuthSuperAdminController::class,'logout']);


    });

    Route::get('/email',[EmailController::class,'email']);



});
Route::middleware('auth:api')->group(function ()
{
    Route::get('allBill',[CommunicatioController::class,'search']);//search for all Bill
    Route::get('payBill',[CommunicatioController::class,'PaySearch']);//pay for a bill by id
    Route::get('payedBill',[CommunicatioController::class,'searchPayed']);//search for payed Bill
    Route::get('NotpayedBill',[CommunicatioController::class,'searchUnPayed']);//search for unpayed Bill

});
/// super admin log in


// seper Admin route
Route::get('profile',function(){
    return 'Unauthenticated user';
})->name('login');
Route::group([
    'middleware' => 'App\Http\Middleware\AuthSuperAdmin:super_admin-api',
    'prefix' => 'Super_admin',

], function () {


    Route::post('AddAdmin',[SuperAdminController::class,'NewAdmin']);
    Route::post('update',[SuperAdminController::class,'update']);
    Route::get('getSubs',[SuperAdminController::class,'getSubs']);
    Route::post('adduser',[SuperAdminController::class,'adduser']);

});

