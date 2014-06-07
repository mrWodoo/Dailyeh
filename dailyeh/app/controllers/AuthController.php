<?php

class AuthController extends BaseController {
    /**
     * Display login form
     *
     * @param bool $loggedOut Show 'logged out' box?
     * @return mixed
     */
    public function loginForm( $loggedOut = false ) {
        // We check if current client is logged in
        // if yes, redirect to index
        if( Session::get( 'user.admin' ) == true ) {
            return Redirect::action( 'DailyController@getIndex' );
        }

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
                'loginFailed' => $loginFailed,
                'loggedOut' => $loggedOut
            ) );
        }
    }

    /**
     * Logout
     *
     * @return mixed
     */
    public function logout() {
        if( Session::get( 'user.admin' ) ) {
            Session::set( 'user.admin', false );
        }

        return $this->loginForm( true );
    }
}