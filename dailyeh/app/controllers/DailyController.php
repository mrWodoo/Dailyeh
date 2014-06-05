<?php

class DailyController extends BaseController {

    /**
     * Constructor. Adds filter to controller
     */
    public function __construct() {
        $this->beforeFilter( 'auth' );
    }

    /**
     * Index page controller
     * @return mixed
     */
    public function getIndex()
    {
        return View::make( 'index' );
    }

}
