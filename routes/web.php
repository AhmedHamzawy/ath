<?php
use Illuminate\Support\Facades\Artisan;

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




Auth::routes();

Route::get('/profile/{id?}', 'HomeController@profile');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/services', 'HomeController@services');
Route::get('/states', 'HomeController@states');
Route::get('/statuses', 'HomeController@statuses');
Route::get('/hospitals', 'HomeController@hospitals');
Route::get('/users', 'HomeController@users');
Route::get('/doctors', 'HomeController@doctors');
Route::get('/comments', 'HomeController@comments');
Route::get('/ratings', 'HomeController@ratings');
Route::get('/users', 'HomeController@users');
Route::get('/settings', 'HomeController@settings');
Route::get('/orders', 'HomeController@orders');
Route::get('/hospitalorders/{id?}', 'HomeController@hospitalorders');
Route::get('/contacts', 'HomeController@contacts');
Route::get('/comments', 'HomeController@comments');
Route::get('/bankaccounts', 'HomeController@bankaccounts');
Route::get('/invoice/{id?}', 'HomeController@invoice');
Route::get('/activitylog', 'HomeController@activityLog');
