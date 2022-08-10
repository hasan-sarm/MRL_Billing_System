<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommunicatioController;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthAdminController;
use App\Http\Controllers\AuthSuperAdminController;
use App\Http\Controllers\SubsController;
use App\Http\Controllers\SaharaController;
use App\Http\Controllers\CenimacityController;
use App\Http\Controllers\VipController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\BankAdminController;
use App\Http\Controllers\ElectricController;
use App\Http\Controllers\MinistryController;
use App\Http\Controllers\SpecialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaterController;
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
    //Communication
    Route::get('allBill',[CommunicatioController::class,'search']);//search for all Bill
    Route::get('payBill',[CommunicatioController::class,'PaySearch']);//pay for a bill by id
    Route::get('payedBill',[CommunicatioController::class,'searchPayed']);//search for payed Bill
    Route::get('NotpayedBill',[CommunicatioController::class,'searchUnPayed']);//search for unpayed Bill

    //Water
    Route::get('wallBill',[WaterController::class,'search']);//search for all Bill
    Route::get('wpayBill',[WaterController::class,'PaySearch']);//pay for a bill by id
    Route::get('wpayedBill',[WaterController::class,'searchPayed']);//search for payed Bill
    Route::get('wNotpayedBill',[WaterController::class,'searchUnPayed']);//search for unpayed Bill

    //electric
    Route::get('eallBill',[ElectricController::class,'search']);//search for all Bill
    Route::get('epayBill',[ElectricController::class,'PaySearch']);//pay for a bill by id
    Route::get('epayedBill',[ElectricController::class,'searchPayed']);//search for payed Bill
    Route::get('eNotpayedBill',[ElectricController::class,'searchUnPayed']);//search for unpayed Bill

    // sub
    Route::post('addsub',[SubsController::class,'addSubs']);
    Route::get('yoursub',[SubsController::class,'yoursub']);
    Route::get('removesub',[SubsController::class,'removesub']);

    //All Ministry
    Route::get('AllBill',[MinistryController::class,'search']);//search for all Bill
    Route::get('PayBill',[MinistryController::class,'PaySearch']);//pay for a bill by id
    Route::get('PayedBill',[MinistryController::class,'searchPayed']);//search for payed Bill
    Route::get('notPayedBill',[MinistryController::class,'searchUnPayed']);//search for unpayed Bill


    Route::get('sahara_allBill',[SaharaController::class,'search']);//search for all Bill
    Route::get('sahara_payBill',[SaharaController::class,'PaySearch']);//pay for a bill by id
    Route::get('sahara_payedBill',[SaharaController::class,'searchPayed']);//search for payed Bill
    Route::post('sahara_save',[SaharaController::class,'save']);//save


    Route::get('vip_allBill',[VipController::class,'search']);//search for all Bill
    Route::get('vip_payBill',[VipController::class,'PaySearch']);//pay for a bill by id
    Route::get('vip_payedBill',[VipController::class,'searchPayed']);//search for payed Bill
    Route::get('vip_NotpayedBill',[VipController::class,'searchUnPayed']);//search for unpayed Bill
    Route::post('vip_save',[VipController::class,'save']);//save



    Route::get('Cenimacity_allBill',[CenimacityController::class,'search']);//search for all Bill
    Route::get('Cenimacity_payBill',[CenimacityController::class,'PaySearch']);//pay for a bill by id
    Route::get('Cenimacity_payedBill',[CenimacityController::class,'searchPayed']);//search for payed Bill
    Route::get('Cenimacity_NotpayedBill',[CenimacityController::class,'searchUnPayed']);//search for unpayed Bill
    Route::post('Cenimacity_save',[CenimacityController::class,'save']);//save

    //special subscribes
    Route::get('s_allBill',[SpecialController::class,'search']);//search for all Bill
    Route::get('s_payBill',[SpecialController::class,'PaySearch']);//pay for a bill by id
    Route::post('s_save',[SpecialController::class,'save']);//save

    // user info
    Route::get('profile',[UserController::class,'profile']); //profile
    Route::post('update',[UserController::class,'update']);// update profile



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

Route::group([
    'middleware' => 'App\Http\Middleware\AuthSuperAdmin:super_admin-api',
    'prefix' => 'Super_admin',

], function () {


    Route::post('AddAdmin',[SuperAdminController::class,'NewAdmin']);
    Route::post('update',[SuperAdminController::class,'update']);
    Route::get('getSubs',[SuperAdminController::class,'getSubs']);
    Route::post('adduser',[SuperAdminController::class,'adduser']);

});
Route::group([
    'middleware' => 'App\Http\Middleware\AuthenticateAdmin:admin-api',
    'prefix' => 'admin',

], function () {



    Route::get('showalluser',[AdminController::class,'showAllUser']);
    Route::post('showallbill',[AdminController::class,'showUserBill']);
    Route::post('update',[AdminController::class,'update']);
    //Bank admin
    Route::post('transinfo',[BankAdminController::class,'transinfo']);
    Route::post('addacc',[BankAdminController::class,'addacc']);
    Route::post('softdelete',[BankAdminController::class,'deleteacc']);


});

