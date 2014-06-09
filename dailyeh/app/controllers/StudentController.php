<?php
class StudentController extends BaseController {
    /**
     * Display students as HTML page
     *
     * @return mixed
     */
    public function listStudents() {
        //Fetch students from database
        $students = Student::all();

        return View::make( 'studentsList', array(
            'students' => $students
        ) );
    }

    /**
     * Remove student
     *
     * @param int $id
     * @param string $token CSRF token
     */
    public function removeStudent( $id, $token ) {
        if( $token != csrf_token() ) {
            $response = Response::make( XMLHelper::ajaxError( 'Błędny token CSRF!' ) );

            XMLHelper::setHeaders( $response );

            return $response;
        }

        // Just to be sure
        $id = (int) $id;

        //Only AJAX requests
        if( Request::ajax() && $id > 0 ) {
            $student = Student::find( $id );

            if( $student ) {
                if( $student->delete() ) {
                    $response = Response::make( XMLHelper::ajaxResponse( 'Uusnięto ucznia!' ) );
                } else {
                    $response = Response::make( XMLHelper::ajaxResponse( 'Nie udało się usunąć ucznia!' ) );
                }
            } else {
                $response = Response::make( XMLHelper::ajaxError( 'Taki uczeń nie istnieje!' ) );
            }

            XMLHelper::setHeaders( $response );

            return $response;
        } else {
            // When it's not ajax request
            // we completely do nothing
            return '';
        }
    }

    /**
     * Add new student
     */
    public function addStudent() {
        $student = new Student;

        // Store information about which columns
        // we can update and which are required, so 'student adding' is more flexible
        $fillables = $student->fillables();
        $required = $student->required();

        // Store data sent by client
        $sentData = Input::all();

        //Count errors
        $errors = 0;

        // Parse this data
        foreach( $sentData AS $key => $value ) {
            // First of all let's check if we can use this information
            if( in_array( $key, $fillables ) ) {
                $student->$key = $value;
            } else if( in_array( $key, $required ) && strlen( $value ) <= 0 ) {
                // This information is required, but not sent by client
                $errors++;
            }
        }


        // If no errors occured then save data in database
        // and show xml representation of recently added student
        if( !$errors ) {
            $student->save();

            $response = Response::make( $student->xml() );
        } else {
            $response = Response::make( XMLHelper::ajaxError( 'Wystąpił błąd!' ) );
        }

        XMLHelper::setHeaders( $response );

        return $response;
    }

    /**
     * Edit student
     *
     * @param integer $id
     * @param string $token CSRF token
     * @return mixed
     */
    public function editStudent( $id, $token ) {
        if( $token != csrf_token() ) {
            $response = Response::make( XMLHelper::ajaxError( 'Błędny token CSRF!' ) );

            XMLHelper::setHeaders( $response );

            return $response;
        }

        // Just to be sure
        $id = (int) $id;

        //Only AJAX requests
        if( Request::ajax() && $id > 0 ) {
            $student = Student::find( $id );

            // Count errors
            $errors = 0;

            if( $student ) {
                $data = Input::all();

                foreach( $data AS $key => $value ) {
                    // First of all let's check if we can use this information
                    if( in_array( $key, $student->fillables() ) ) {
                        $student->$key = $value;
                    } else if( in_array( $key, $student->required() ) && strlen( $value ) <= 0 ) {
                        // This information is required, but not sent by client
                        $errors++;
                    }
                }

                if( !$errors ) {

                    if( $student->save() ) {
                        $response = Response::make( $student->xml() );
                    } else {
                        $response = Response::make( XMLHelper::ajaxError( 'Nie udało się zapisać zmians!' ) );
                    }
                } else {
                    $response = Response::make( XMLHelper::ajaxError( 'Nie wypełniłeś wymaganych pól!' ) );
                }
            } else {
                $response = Response::make( XMLHelper::ajaxError( 'Taki uczeń nie istnieje!' ) );
            }

            XMLHelper::setHeaders( $response );

            return $response;
        } else {
            // When it's not ajax request
            // we completely do nothing
            return '';
        }
    }
}