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
        Route::post('/items/register-item','ItemsController@store')->name('item-register');
        Route::get('/items/delete-item/{idItem}','ItemsController@deleteItem');

        Route::get('/conditions/view-conditions', 'ConditionsController@index')->name('conditions');
        Route::post('/conditions/register-condition', 'ConditionsController@store')->name('condition-register');
        Route::get('/conditions/all-conditions', 'ConditionsController@getConditions');
        Route::get('/conditions/consult-condition/{id}', 'ConditionsController@consultCondition');
        Route::post('/conditions/update-condition/{id}', 'ConditionsController@updateCondition');
        
        Route::get('/shipments/view-shipments', 'ShipmentsController@index')->name('shipments');
        Route::post('/shipments/register-shipment', 'ShipmentsController@store')->name('shipment-register');
        Route::get('/shipments/all-shipments', 'ShipmentsController@getShipments');
        Route::get('/shipments/consult-shipment/{id}', 'ShipmentsController@consultShipment');
        Route::post('/shipments/update-shipment/{id}', 'ShipmentsController@updateShipment');

        Route::get('/status/view-status', 'StatusController@index')->name('status');
        Route::post('/status/register-status', 'StatusController@store')->name('status-register');
        Route::get('/status/all-status', 'StatusController@getStatus');
        Route::get('/status/consult-status/{id}', 'StatusController@consultStatus');
        Route::post('/status/update-status/{id}', 'StatusController@updateStatus');

        Route::get('/customers/view-customers', 'CustomersController@index')->name('customers');
        Route::post('/customers/register-customer', 'CustomersController@store');
        Route::get('/customers/all-customers', 'CustomersController@getCustomers');
        Route::get('/customers/consult-customer/{idCustomer}', 'CustomersController@viewCustomer');
        Route::post('/customers/{idCustomer}', 'CustomersController@updateCustomer');
        Route::get('/customers/delete-customer/{idCustomer}', 'CustomersController@deleteCustomer');

        Route::get('/customers/view-sub-customers/{idCustomer}', 'CustomersController@viewSubCustomers')->name('sub-customers');
        Route::get('/customers/view-sub-customers/get-sub-customers/{idCustomer}', 'CustomersController@getSubCustomerOfCustomer');
        Route::post('/customers/view-sub-customers/register-sub-customer','CustomersController@registerSubCustomer');
        Route::get('/customers/view-sub-customers/all-sub-customers/{idCustomer}', 'CustomersController@getSubCustomers');
        Route::post('/customers/view-sub-customers/delete-sub-customer','CustomersController@deleteSubCustomer');

        Route::get('/items/consult-sub-customer/{idCustomer}','ItemsController@consultSubCustomer');
        Route::post('/items/register-close/{idItem}','ItemsController@closeItem')->name('item-close');

        Route::get('/items/view-items','ItemsController@index')->name('items');
        Route::get('/items/all-items','ItemsController@getItems');
        Route::get('/items/consult-item/{idItem}','ItemsController@consultItem');
        Route::post('/items/update-item/{idItem}','ItemsController@updateItem');

        Route::get('user/get-list', 'UserController@getList')->name('user.get-list');
        Route::resource('user', 'UserController');
});

