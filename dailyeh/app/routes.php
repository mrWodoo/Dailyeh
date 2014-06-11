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
Route::get( '/students', 'StudentController@listStudents' );

/**
 * Group routes with CSRF filter
 */
Route::group( array( 'before' => 'csrf' ), function()  {
    Route::post( '/students/add', 'StudentController@addStudent' );
    Route::post( '/presence/set', 'PresenceController@setPresence' );
});

Route::get( '/logout/{token}', 'AuthController@logout' );
Route::get( '/students/remove/{id}/{token}', 'StudentController@removeStudent')->where('id', '[0-9]+');
Route::post( '/students/edit/{id}/{token}', 'StudentController@editStudent')->where('id', '[0-9]+');
Route::get( '/presence', 'PresenceController@index' );
Route::get( '/presence/{date}', array( 'as' => 'presenceView', 'uses' => 'PresenceController@view' ) )->where( 'date', '([0-9]{4})\-([0-9]{1,2})\-([0-9]{1,2})' );
Route::get( '/presence/student/{name}/{id}', 'PresenceController@studentPresence' )->where( array(
    'name' => '([a-zA-Z0-9\-]{1,128})',
    'id' => '([0-9]{1,4})' ) );