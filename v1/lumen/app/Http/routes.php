<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->group(['prefix'=>'v1'],function() use($app){
	$app->get('/', function () use ($app) {
	    return redirect(url('../project'));
	});
});
$app->group(['prefix'=>'v1','middleware'=>'App\Http\Middleware\OAuth'],function() use($app){
	$app->post('product/search','App\Http\Controllers\productController@search');
	$app->get('product/{id}/edit','App\Http\Controllers\productController@edit');
	$app->put('product/{id}/edit','App\Http\Controllers\productController@update');
	$app->delete('product/{id}/delete','App\Http\Controllers\productController@delete');
	$app->post('product/store','App\Http\Controllers\productController@store');
});

