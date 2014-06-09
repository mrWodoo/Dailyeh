<?php
class TranslationHelper {
    /**
     * Translate month (@date( 'm )) to polish month name
     *
     * @param integer $month
     * @return string
     */
    public static function translateMonth( $month ) {
        $month = (int) $month;

        if( $month <= 0 || $month > 12 ) {
            $month = '01';
        }

        if( substr( $month, 0, 1 ) == '0' ) {
            $month = (int) substr( $month, 1, 2 );
        }

        $translations = array(
            'Styczeń',
            'Luty',
            'Marzec',
            'Kwiecień',
            'Maj',
            'Czerwiec',
            'Lipiec',
            'Sierpień',
            'Wrzesień',
            'Październik',
            'Listopad',
            'Grudzień'
        );

        // Decrement to match array index
        $month -= 1;

        return $translations[ $month ];
    }
}