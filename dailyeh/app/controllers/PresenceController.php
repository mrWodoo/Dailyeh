<?php
class PresenceController extends BaseController {

    /**
     * Display list of years, months, days
     *
     * @return mixed
     */
    public function index() {

        $presences = Presence::all()->groupBy( 'date', 'desc' );

        // Which days have some presence
        $withPresence = Presence::uniqueDates();

        // We store our dates
        $dates = array();

        // Generate dates from when Dailyeh was installed
        // till present date
        $startDate = new DateTime( Config::get( 'dailyeh.installed_at' ) );
        $endDate = new DateTime( date( 'Y-m-d' ) );

        do {
            $year = $startDate->format( 'Y' );
            $month = $startDate->format( 'm' );
            $day = $startDate->format( 'd' );

            if( !isset( $dates[ $year ] ) ) {
                $dates[ $year ] = array();
            }

            if( !isset( $dates[ $year ][ $month ] ) ) {
                $dates[ $year ][ $month ] = array();
            }

            $dates[ $year ][ $month ][ $day ] = array(
                'hadPresence' => ( in_array( $startDate->format( 'Y-m-d' ), $withPresence ) ) ? true : false
            );


           $startDate->modify( '+1 day' );
        } while( $startDate <= $endDate );


        return View::make( 'presence.index', array(
            'dates' => $dates
        ) );
    }

    /**
     * Display presence list
     *
     * @param $date
     */
    public function view( $date ) {

        $presenceList = Student::studentsPresent( $date );

        return View::make( 'presence.view', array(
            'date' => $date,
            'presenceList' => $presenceList
        ) );
    }

    /**
     * Set 'present' or not
     *
     * @return mixed
     */
    public function setPresence() {
        //Only AJAX requests
        if( Request::ajax() ) {
            $presence = Presence::where( 'student_id', '=', Input::get( 'student_id' ) )->where( 'date', '=', Input::get( 'date' ) )->first();
            $student = Student::find( Input::get( 'student_id' ) );

            // Count errors
            $errors = 0;

            // Only process if student exists
            if( $student instanceof Student ) {
                if( !$presence ) {
                    // If we don't have a presence record
                    // we create new
                    $presence = new Presence;
                    $presence->student_id = Input::get( 'student_id' );
                    $presence->date = Input::get( 'date' );
                    $presence->presence = ',,,,,,,';

                    if( !$presence->save() ) {
                        $response = Response::make( XMLHelper::ajaxError( 'Nie można utworzyć nowej obecności!' ) );
                        $errors++;
                    }

                }

                // If we have no errors
                // we can update presence list
                if( !$errors ) {
                    // Prepare presence value for further parsing
                    $presenceList = $presence->presence;

                    $presenceList = explode( ',', $presenceList );

                    // Fill to 8 elements
                    if( count( $presenceList ) < 8 ) {
                        for( $i = count( $presenceList ); $i < 8; $i++ ) {
                            $presenceList[ $i ] = '';
                        }
                    }

                    if( Input::get( 'hour' ) < 0 || Input::get( 'hour' ) > 7 ) {
                        $response = Response::make( XMLHelper::ajaxError( 'Godzina wykracza poza granicę!' ) );
                    } else {
                        $presenceList[ Input::get( 'hour' ) ] = ( Input::get( 'present' ) ) ? 1 : 0;

                        // Now make string of this array and save it
                        $presenceList = implode( ',', $presenceList );

                        $presence->presence = $presenceList;

                        if( $presence->save() ) {
                            $response = Response::make( XMLHelper::ajaxResponse( 'Zaktualizowano obecność!' ) );
                        } else {
                            $response = Response::make( XMLHelper::ajaxError( 'Nie udało się zapisać zmian!' ) );
                        }
                    }


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
     * Show student's presence
     *
     * @param string $name Slug
     * @param int $id student id
     * @return mixed
     */
    public function studentPresence( $name, $id ) {
        $id = (int) $id;

        $student = Student::find( $id );

        if( $student ) {
            $presence = $student->presence;

            return View::make( 'presence.student', array(
                'presence' => $presence,
                'student' => $student
            ) );
        } else {
            return $this->message( 'Taki uczeń nie istnieje!' );
        }
    }
}