<?php

class BaseController extends Controller {

    /**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

    /**
     * Display page with some message
     *
     * @param string $message
     * @return mixed
     */
    public function message( $message ) {
        return View::make( 'message', array( 'message' => $message ) );
    }

}
