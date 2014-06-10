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

    /**
     * Translate presence format date (YYYY-mm-dd) to text (dd mm YYYY
     *
     * @param string $date
     * @return string
     */
    public static function translateDate( $date ) {
        $exp = explode( '-', $date );

        if( substr( $exp[2], 0, 1 ) == 0 ) {
            $exp[2] = substr( $exp[2], 1, strlen( $exp[2] ) );
        }

        return $exp[2] . ' ' . self::translateMonth( $exp[1] ) . ' ' . $exp[0];
    }
}