<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


// Customer Web APIs
Route::post('store/order/details','OrderController@store'); 
Route::get('populate/initial/data','OrderController@CustomerOrderPlaceInitialData');
Route::post('populate/orderDetails','OrderController@CustomerOrderDetails');

//Supplier
Route::post('confirm/order/details','SupplierOrderController@store');
Route::post('populate/all/orderDetails','OrderController@AllCustomerOrderDetails');
Route::get('/register', 'Auth\RegisterController@getRegister')->name('register');
