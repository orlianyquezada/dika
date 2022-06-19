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
    Route::get('/customers', 'CustomersController@index')->name('customers');
    Route::get('allCustomers', 'CustomersController@GetCustomers');
    Route::post('/customers', 'CustomersController@store')->name('customerRegisterPost');
    Route::get('/viewCustomer/{idCustomer}', 'CustomersController@viewCustomer');
    Route::post('/customers/{idCustomer}', 'CustomersController@updateCustomer');
    Route::get('/deleteCustomer/{idCustomer}', 'CustomersController@deleteCustomer');
    
    
    //Movements
    Route::get('/movements', 'MovementsController@index')->name('movements');
    Route::post('/movements', 'MovementsController@store')->name('movementsRegister');
    
    Route::get('user/get-list', 'UserController@getList')->name('user.get-list');
    Route::resource('user', 'UserController');
});

