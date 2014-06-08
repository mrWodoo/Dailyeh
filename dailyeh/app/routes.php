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
Route::any( '/students', 'StudentController@listStudents' );

/**
 * Group routes with CSRF filter
 */
Route::group( array( 'before' => 'csrf' ), function()  {
    Route::post( '/students/add', 'StudentController@addStudent');
});

Route::any( '/logout/{token}', 'AuthController@logout' );
Route::get( '/students/remove/{id}/{token}', 'StudentController@removeStudent')->where('id', '[0-9]+');