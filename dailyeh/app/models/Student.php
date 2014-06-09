<?php
class Student extends Eloquent {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * Columns which can be updated
     *
     * @var array
     */
    protected $fillable = array( 'name', 'surname', 'pesel', 'street_address' );

    /**
     * Which columns are required on insert
     *
     * @var array
     */
    protected $required = array( 'name', 'surname', 'pesel', 'street_addres' );

    /**
     * Which columns are shown at StudentController@listStudents
     *
     * @var array
     */
    protected $show = array(
        'name' => 'Imię',
        'surname' => 'Nazwisko',
        'pesel' => 'PESEL',
        'street_address' => 'Adres zamieszkania',
        'created_at' => 'Dodano',
        'updated_at' => 'Ostatnia aktualizacja');

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
     * Which fields to show on StudentController@listStudents
     *
     * @return array
     */
    public function toShow() {
        return $this->show;
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