<?php

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

Route::get('/add-stock', "Stock@getAddStock")->middleware('auth');

Route::get('/get-stock', "Stock@getStock")->middleware('auth');

Route::get('/edit-stock/{item_id}', "Stock@editStock")->middleware('auth');

Route::post('/edit-stock/{item_id}', "Stock@saveEditStock")->middleware('auth');

Route::post('/add-stock', "Stock@addStock")->middleware('auth');

Route::get('/get-current-stock', "Stock@getCurrentStock")->middleware('auth');

Route::get('/check-out', "Checkout@getCheckout")->middleware('auth');

Route::get('/add-new-item', "Stock@getAddNewItem")->middleware('auth');

Route::post('/add-new-item', "Stock@addNewItem")->middleware('auth');

Route::get('/search-stock/{item_name}', "Stock@searchStock")->middleware('auth');

Route::get('/delete-item', "Stock@deleteStock");

Auth::routes();

//AUTHENTICATION
Route::get('/add-user', function (){
    $state = 0;
    return view("auth.register", compact('state'));
})->middleware('auth');

Route::post('/add-user', "Authentication@addNewUser")->middleware('auth');

Route::get('/delete-user/{user_id}', "Authentication@deleteUser")->middleware('auth');

Route::get('/user-login', function (){
    $state = 0;
    return view("auth.login", compact('state'));
});

Route::post('/login', "Authentication@userLogin");

Route::get('/get-users', "Authentication@getUsers")->middleware('auth');

Route::get('/login', function (){
    return redirect()->intended('/user-login');
})->name('login');

Route::get('/get-user-data/{user_id}', "Authentication@getUserData")->middleware('auth');

Route::get('/submit-edit-user', "Authentication@editUserData")->middleware('auth');

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

//CHECKOUT
Route::get('/calculate-checkout-list', "Checkout@calculateCheckoutList")->middleware('auth');

Route::get('/checkout', "Checkout@checkout");


//SALES
Route::get('/get-sales-records', "Sales@getSalesRecords");

Route::get('/filter-sales-records/{from}/{to}', "Sales@filterSalesRecords");

Route::get('/calculate-filtered-subtotal', "Sales@calculateSubtotal");

//ALERTS
Route::get('/check-system-alerts', "Alerts@checkForNewMessages");

Route::get('/system-alerts', "Alerts@getAlerts");

Route::get('/count-new-alerts', "Alerts@countNewAlerts");

Route::get('/check-low-stock-count', "Alerts@checkLowStocksCount");

Route::get('/dismiss-message', "Alerts@dismissMessage");

Route::get('/prepare-invoice', "Checkout@prepareInvoice");