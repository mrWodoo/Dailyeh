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

    /**
     * Override 'deletion' because
     * we need to remove also presence data
     * for this student
     *
     * @return mixed
     */
    public function delete() {

        DB::delete( '
            DELETE FROM ' . DB::getTablePrefix() . 'students
            WHERE id = ?', array( $this->id ) );

        return parent::delete();
    }

    /**
     * Get students' presence list
     * This should be faster than Laravel's models' relations
     *
     * @param string $date Format YYYY-mm-dd
     * @return array
     */
    public static function studentsPresent( $date ) {
        $result = DB::select( '
            SELECT students.*, students.id AS student, presence.*
            FROM ' . DB::getTablePrefix() . 'students AS students
            LEFT JOIN ' . DB::getTablePrefix() . 'presence AS  presence
            ON students.id = presence.student_id
            AND date = ?', array( $date ) );

        return $result;
    }
}