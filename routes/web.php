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
    Route::prefix('customers')->group(function () {
        //Customers
        Route::get('/customers', 'CustomersController@index')->name('customers');
        Route::post('/customers', 'CustomersController@store')->name('customer-register');
        Route::get('/all-customers', 'CustomersController@getCustomers');
        Route::get('/view-customer/{idCustomer}', 'CustomersController@viewCustomer');
        Route::post('/{idCustomer}', 'CustomersController@updateCustomer');
        Route::get('/delete-customer/{idCustomer}', 'CustomersController@deleteCustomer');
    });
    
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

