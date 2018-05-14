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





Route::get('/', function () {return view('greeting');})->name('greeting');


//Dashboard
Route::get('/dashboard/juliaUsage', 'MainPanelController@dashboard')->name('dashboard')->middleware('LoginGate');
Route::get('/dashboard/myChecks', 'MainPanelController@myChecks')->middleware('LoginGate');
Route::get('/dashboard/similarities/{julias_check_id}', 'MainPanelController@similarities')->middleware('LoginGate');
Route::get('/dashboard/similarities/{julias_check_id}/similarity/{julia_similarity_id}', 'MainPanelController@similarity')->middleware('LoginGate');
//Admin Panel
Route::get('/adminPanel/allUsers', 'MainPanelController@allUsers')->middleware('LoginGate');
Route::get('/adminPanel/admins', 'MainPanelController@admins')->middleware('LoginGate');
Route::get('/adminPanel/ordinaryUsers', 'MainPanelController@ordinaryUsers')->middleware('LoginGate');
Route::get('/adminPanel/addNewUser', 'MainPanelController@addNewUser')->middleware('LoginGate');
Route::post('/addNewUser', 'MainPanelController@addNewUser2')->middleware('LoginGate');

//OAuth
Route::get('/singin', 'AuthController@signin')->name('singin');
Route::get('/authorize', 'AuthController@gettoken');
Route::get('/noUserFound', 'AuthController@noUserFound')->name('noUserFound');
Route::get('/logout', 'AuthController@logout');

//Julia API usage
Route::post('/dashboard/juliaUsage', 'juliaUsage@juliaUsage');
