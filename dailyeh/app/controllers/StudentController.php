<?php
class StudentController extends BaseController {
    /**
     * Display students as HTML page
     *
     * @return mixed
     */
    public function listStudents() {
        $student = new Student;
        $student->name = 'Jan';
        $student->surname = 'Kowalski';
        $student->save();
    }
}