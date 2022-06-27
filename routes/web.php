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
    
    //Movements
    Route::get('/movements/view-movements', 'MovementsController@index')->name('movements');
    Route::post('/movements/register-movement', 'MovementsController@store')->name('movement-register');
    Route::get('/movements/all-movements', 'MovementsController@getMovements');
    Route::get('/movements/view-movement/{idMovement}', 'MovementsController@viewMovement');
    Route::post('/movements/{idMovement}', 'MovementsController@updateMovement');
    Route::get('/movements/delete-movement/{idMovement}', 'MovementsController@deleteMovement');
    
    //Users
    Route::get('user/get-list', 'UserController@getList')->name('user.get-list');
    Route::resource('user', 'UserController');
});

