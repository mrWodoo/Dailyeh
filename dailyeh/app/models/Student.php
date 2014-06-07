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
    protected $fillable = array( 'name', 'surname' );
}