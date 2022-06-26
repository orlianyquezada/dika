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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    //Customers
    Route::get('/customers/view-customers', 'CustomersController@index')->name('customers');
    Route::post('/customers/register-customer', 'CustomersController@store')->name('customer-register');
    Route::get('/customers/all-customers', 'CustomersController@getCustomers');
    Route::get('/customers/consult-customer/{idCustomer}', 'CustomersController@viewCustomer');
    Route::post('/customers/{idCustomer}', 'CustomersController@updateCustomer');
    Route::get('/customers/delete-customer/{idCustomer}', 'CustomersController@deleteCustomer');

    //Sub Customers
    Route::get('/sub-customers/view-sub-customers','SubCustomersContoller@index')->name('sub-customers');
    
    //Movements
    Route::get('/movements/movements', 'MovementsController@index')->name('movements');
    Route::post('/movements/movements', 'MovementsController@store')->name('movements-register');
    Route::get('/movements/allMovements', 'MovementsController@getMovements');
    Route::get('/movements/viewMovement/{idMovement}', 'MovementsController@viewMovement');
    Route::post('/movements/{idMovement}', 'MovementsController@updateMovement');
    Route::get('/movements/deleteMovement/{idMovement}', 'MovementsController@deleteMovement');
    
    //Users
    Route::get('user/get-list', 'UserController@getList')->name('user.get-list');
    Route::resource('user', 'UserController');
});

