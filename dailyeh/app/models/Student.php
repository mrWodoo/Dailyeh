<?php
class Student extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * Columns which can be updated and which are required when inserting
     *
     * @var array
     */
    protected $fillable = array( 'name', 'surname', 'pesel', 'street_address' );
    protected $required = array( 'name', 'surname', 'pesel', 'street_addres' );

    /**
     * Get fillable fields
     *
     * @return array
     */
    public function fillables() {
        return $this->fillable;
    }

    /**
     * Get fillable fields
     *
     * @return array
     */
    public function required() {
        return $this->required;
    }

    /**
     * Generate xml with student's data
     *
     * @return string
     */
    public function xml() {
        $xml = new SimpleXMLElement( '<student/>' );

        $data = $this->attributesToArray();

        foreach( $data AS $key => $value ) {
            $xml->addChild( $key, addslashes( $value ) );
        }

        return $xml->asXML();
    }
}