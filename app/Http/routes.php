<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get("/", "HomeController@index");

Route::get("/detail", "HomeController@detail");
Route::get("/chat", "HomeController@chat");
Route::get("/about", "HomeController@about");
Route::get("/change-country/{country}", "HomeController@changeCountry");

