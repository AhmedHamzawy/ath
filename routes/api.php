<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::post('updateprofile' ,'UsersController@store');
Route::post('users/changepassword/{id}' ,'UsersController@changepassword');
Route::post('users/resetpassword' ,'API\UserController@passwordReset');
Route::post('users/upload/{id}' ,'UsersController@upload');
Route::get('users/{id}' ,'UsersController@show');

//vue
Route::get('allusers' ,'UsersController@index');
Route::post('getuser' ,'UsersController@show');
Route::post('adduser' ,'UsersController@store');
Route::post('updateuser' ,'UsersController@store');
Route::post('deleteuser/{user_id}' ,'UsersController@destroy');


Route::get('allservices' , 'ServicesController@index');
Route::get('getservices' , 'ServicesController@allActiveServices');
Route::post('addservice' ,'ServicesController@store');
Route::post('updateservice', 'ServicesController@store');
Route::post('deleteservice/{service_id}/{user_id}', 'ServicesController@destroy');

Route::get('gethospitals' , 'HospitalsController@index');
Route::get('allhospitals' , 'HospitalsController@getHospitals');

//Vue
Route::post('addhospital' , 'HospitalsController@store');

Route::post('updatehospital', 'HospitalsController@store');
Route::get('showhospital', 'HospitalsController@show');
Route::get('getservicedoctorshospitals', 'HospitalsController@serviceDoctorsHospitals');
Route::post('deletehospital/{hospital_id}', 'HospitalsController@destroy');


Route::get('getdoctors' , 'DoctorsController@index');
Route::get('alldoctors' , 'DoctorsController@getDoctors');
Route::get('getdoctor/{doctor_id}/{user_id}' , 'DoctorsController@show');
Route::get('getdoctor/{doctor_id}' , 'DoctorsController@getDoctor');
Route::post('adddoctor' ,'DoctorsController@store');
Route::post('updatedoctor', 'DoctorsController@store');
Route::get('offers', 'DoctorsController@offers');
Route::get('doctorsservice/{service_id}', 'DoctorsController@doctorsService');
Route::get('doctorshospital/{hospital_id}', 'DoctorsController@doctorsHospital');
Route::post('deletedoctor/{doctor_id}', 'DoctorsController@destroy');
Route::post('doctors/upload/{id}' ,'DoctorsController@upload');



Route::get('getstates' , 'StatesController@index');
Route::post('addstate' ,'StatesController@store');
Route::post('updatestate', 'StatesController@store');
Route::post('deletestate/{state_id}/{user_id}', 'StatesController@destroy');


Route::get('getstatuses' , 'StatusesController@index');
Route::get('allstatuses' , 'StatusesController@getStatuses');
Route::post('addstatus' ,'StatusesController@store');
Route::post('updatestatus', 'StatusesController@store');
Route::post('deletestatus/{status_id}/{user_id}', 'StatusesController@destroy');


Route::get('allcomments' , 'CommentsController@index');
Route::get('getdoctorcomments/{id}' , 'CommentsController@getDoctorComments');
Route::post('postcomment' ,'CommentsController@store');
Route::post('deletecomment/{comment_id}/{user_id}', 'CommentsController@destroy');

// Vue
Route::get('allcontacts' , 'ContactsController@index');

Route::post('postcontact' , 'ContactsController@store');

Route::post('updatesettings/1' , 'SettingsController@update');
Route::get('getsettings' , 'SettingsController@index');


Route::post('postrating/{id}' , 'UsersController@StoreRating');
Route::get('allratings' , 'UsersController@getRatings');



Route::post('neworder' , 'OrdersController@store');
Route::post('updateorder' , 'OrdersController@store');
Route::get('getorder/{id}' , 'OrdersController@show');
Route::get('clientorders/{id}' , 'OrdersController@clientorders');
Route::get('hospitalorders/{id}' , 'OrdersController@hospitalorders');
Route::get('doctororders/{id}' , 'OrdersController@doctororders');
Route::get('allorders' , 'OrdersController@index');

// Vue
Route::get('showhospitalorders/{id}' , 'OrdersController@showHosptialOrders');


Route::get('allbankaccounts' , 'BankAccountsController@index');
Route::post('addbankaccount' , 'BankAccountsController@store');
Route::post('updatebankaccount' , 'BankAccountsController@store');
Route::post('deletebankaccount/{bankaccount_id}/{user_id}' , 'BankAccountsController@destroy');


Route::get('allinvoices' , 'InvoicesController@index');
Route::get('getinvoice/{id}' , 'InvoicesController@show');
