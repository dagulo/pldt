<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get( '/', 'FrontController@index' );
Route::get( 'ask', 'FrontController@ask' );
Route::get( 'complain', 'FrontController@complain' );


Route::group( [ 'prefix' => 'ajax' , 'namespace' => 'Ajax' ] , function(){
    Route::post( 'chat', 'AjaxChatController@chat' );
    Route::post( 'chat/getAccountBill', 'AjaxChatController@getAccountBill' );
    Route::post( 'pay', 'AjaxPaymentController@pay' );
});


