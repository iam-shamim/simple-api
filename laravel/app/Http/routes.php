<?php
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@showLoginForm']);
    Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
    Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

// Registration Routes...
    Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
    Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);

// Password Reset Routes...
    Route::get('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
    Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
    Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);
    Route::get('home',['as'=>'home','uses'=>'HomeController@index']);
    
    Route::group(['middleware'=>'auth'],function(){
        Route::get('app',['as'=>'app.index','uses'=>'appController@index']);
        Route::get('app/new',['as'=>'app.create','uses'=>'appController@create']);
        Route::post('app/new',['as'=>'app.create','uses'=>'appController@store']);
        Route::get('app/{id}/delete',['as'=>'app.destroy','uses'=>'appController@destroy']);
        Route::post('app/secret',['as'=>'app.secret','uses'=>'appController@secret']);
        Route::get('products',['as'=>'product.index','uses'=>'productController@index']);
        Route::get('products/{id}/search',['as'=>'product.search','uses'=>'productController@search']);
        Route::get('products/create',['as'=>'product.create','uses'=>'productController@productMultiCreate']);
    });


