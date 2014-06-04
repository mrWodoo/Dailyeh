<?php

class LoginController extends BaseController {
    public function loginForm() {
        return View::make( 'login' );
    }
}