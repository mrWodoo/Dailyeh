<?php

class LoginController extends BaseController {
    /**
     * Display login form
     *
     * @return mixed
     */
    public function loginForm() {
        $loginProcessed = false;
        $loginFailed = false;

        // Should we process login form?
        if( Input::has( 'login' ) ) {
            // Yarr!
            $loginProcessed = true;

            // Compare password and login
            if( Input::get( 'login' ) == Config::get( 'dailyeh.admin.login' ) && Hash::check( Input::get( 'password' ), Config::get( 'dailyeh.admin.password' ) ) ) {
                $loginFailed = false;
            } else {
                $loginFailed = true;
            }
        }

        // Display login form, or redirect to index
        // with admin privileges
        if( $loginProcessed == true && !$loginFailed ) {
            Session::set( 'user.admin', true );

            return Redirect::action( 'DailyController@getIndex' );
        } else {
            return View::make( 'login', array(
                'loginProcessed' => $loginProcessed,
                'loginFailed' => $loginFailed
            ) );
        }
    }
}