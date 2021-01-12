<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\http\Controllers\AdminSettingController;
use App\Http\Controllers\UserController;

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'merchantIndex'])->name('home');
Auth::routes();

Route::get('/admin_dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('admin_dashboard')->middleware('role:admin');
Route::get('/merchant_dashboard', [App\Http\Controllers\HomeController::class, 'merchantIndex'])->name('merchant_dashboard')->middleware('role:merchant');

Route::group(['middleware' => 'role:admin'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::post('user/verify/{id}', [App\Http\Controllers\UserController::class, 'verify']);
	Route::post('user/assign_services', [App\Http\Controllers\UserController::class, 'assignServices']);
	Route::get('user/get_services/{id}', [App\Http\Controllers\UserController::class, 'getServices']);
	Route::get('user/delete_services/{id}', [App\Http\Controllers\UserController::class, 'deleteServices']);
	Route::post('user/unlock_merchant/{id}', [App\Http\Controllers\UserController::class, 'unlockBannedUser']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade');
	Route::get('map', function () {return view('pages.maps');})->name('map');
	Route::get('icons', function () {return view('pages.icons');})->name('icons');
	Route::get('table-list', function () {return view('pages.tables');})->name('table');
    Route::resource('bill','App\Http\Controllers\BillTypeController');
    Route::get('setting', 'App\Http\Controllers\AdminSettingController@index');
    Route::post('setting', 'App\Http\Controllers\AdminSettingController@update');
	Route::get('cards',[App\Http\Controllers\UserController::class,'showData']);
	Route::get('invoice','App\Http\Controllers\InvoiceController@index')->name('invoice.index');
	Route::get('bills','App\Http\Controllers\BillController@index')->name('bills.index');
	Route::post('update_ach_schdule', 'App\Http\Controllers\AdminSettingController@updateAchSchdule');
});

Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

Route::group(['middleware' => 'role:merchant'], function () {
    Route::resource('payment','App\Http\Controllers\PaymentController');
	Route::post('calculatePyment', 'App\Http\Controllers\PaymentController@calculatePyment');
	Route::get('pay_now', [App\Http\Controllers\PaymentController::class, 'payNow']);
	Route::post('pay_now', [App\Http\Controllers\PaymentController::class, 'sendPayment']);
	Route::post('user/add_card_to_stripe', [App\Http\Controllers\UserController::class, 'addCardToStripe'])->name('user.add_card_to_stripe');
	Route::get('user_bill_history','App\Http\Controllers\BillController@UserHistory')->name('bills.history');
});


