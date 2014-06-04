<?php

class DailyController extends BaseController {

    public function getIndex()
    {
        // We check if current client is logged in
        // if not, we redirect him to login page
        if( Session::get( 'user.admin' ) != true ) {
            return Redirect::action( 'LoginController@loginForm' );
        }
    }

}
