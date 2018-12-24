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

Route::get( '/contacts', ['as'=>'contacts','uses'=>'ContactCnt@get'] );

Route::get( '/conversation/{id}', ['as'=>'fetchconv','uses'=>'ContactCnt@getMessage']);

Route::post( '/conversation/send', ['as'=>'sendMsg','uses'=>'ContactCnt@sendMsg']);

Route::get('/getPlaces',['as'=>'getPlaces','uses'=>'ContactCnt@getPlaces']);

Route::get('/localizedusers',['as'=>'localizedusers','uses'=>'ContactCnt@localizedusers']);

Route::get('/chat', 'HomeController@index')->name('chat');

Route::post('/changelocation',['as'=>'changelocation','uses'=>'ContactCnt@changelocation']);

Auth::routes();

