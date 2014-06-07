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
}