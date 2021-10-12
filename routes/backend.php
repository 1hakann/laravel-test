<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::get('/admin', 'Admin/AuthController@index');

Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function(Router $router) {

        #Login
        $router -> get(
            '/login', [
                'as' => 'auth.login',
                'uses' => 'AuthController@getLogin',
                'middleware' => ['auth.admin'],
            ]
        );

        $router -> post(
            '/login', [
                'as' => 'auth.login.post',
                'uses' => 'AuthController@postLogin',
                'middleware' => ['auth.admin'],
            ]
        );

        $router -> get(
            '/register', [
                'as' => 'auth.register',
                'uses' => 'AuthController@getRegister'
            ]
        );

        $router -> post(
            '/register', [
                'as' => 'auth.register.post',
                'uses' => 'AuthController@postRegister',
            ]
        );
    }
);
