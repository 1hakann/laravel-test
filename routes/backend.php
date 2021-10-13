<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;


Route::group(
    ['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.' ], function(Router $router) {

        #Dashboard
        $router -> get(
            '/dashboard', [
                'as' => 'auth.index',
                'uses' => 'AuthController@index',
                'middleware' => ['auth.admin'],
            ]
            );

        #Login
        $router -> get(
            '/login', [
                'as' => 'auth.login',
                'uses' => 'AuthController@getLogin',
            ]
        );

        $router -> post(
            '/login', [
                'as' => 'auth.login.post',
                'uses' => 'AuthController@postLogin',
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
