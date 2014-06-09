<?php
class PresenceController extends BaseController {
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
}