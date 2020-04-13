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
 

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');


// Customer Web APIs
Route::post('store/order/details','OrderController@store'); 
Route::get('populate/initial/data','OrderController@CustomerOrderPlaceInitialData');
Route::post('populate/orderDetails','OrderController@CustomerOrderDetails');

//Tempory Customer
Route::get('/free','Auth\TemporyCustomerController@index');

//Supplier
Route::post('confirm/order/details','SupplierOrderController@store');
Route::post('populate/all/orderDetails','OrderController@AllCustomerOrderDetails');
Route::post('populate/supplier/orderDetails','SupplierOrderController@show');
 

//Registration
Route::get('/register', 'Auth\RegisterController@getRegister')->name('register');
Route::post('/user/register', 'Auth\RegisterController@create');

// //Next Order Number
Route::get('next/Order/No','OrderController@nextOrderNo');


