<?php
class Presence extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'presence';

    /**
     * Columns which can be updated
     *
     * @var array
     */
    protected $fillable = array( 'student_id', 'date', 'presence' );

    /**
     * Get student
     *
     * @return Student
     */
    public function student() {
        return $this->hasOne( 'Student' );
    }

    /**
     * Generate xml with student's data
     *
     * @return string
     */
    public function xml() {
        $xml = new SimpleXMLElement( '<presence/>' );

        $data = $this->attributesToArray();

        foreach( $data AS $key => $value ) {
            $xml->addChild( $key, addslashes( $value ) );
        }

        return $xml->asXML();
    }


    /**
     * Get uniqUe dates
     *
     * @return array
     */
    public static function uniqueDates() {
        return DB::table( 'presence' )->distinct( 'date' )->lists( 'date' );
    }
}