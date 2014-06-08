<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
 * Index route
 */
Route::get('/', 'DailyController@getIndex');
Route::any('/login', 'AuthController@loginForm');
Route::any( '/logout', 'AuthController@logout' );
Route::any( '/students', 'StudentController@listStudents' );
Route::get( '/students/remove/{id}', 'StudentController@removeStudent')->where('id', '[0-9]+');
Route::post( '/students/add', 'StudentController@addStudent');