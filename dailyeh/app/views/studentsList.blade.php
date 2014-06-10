@extends('layouts.layout')

@section('content')


<div class="container margin-top-small">
    <?php

    if( count( $students) ) {

    ?>
    <div class="table-responsive">
        <h2>Lista uczniów <small><?php echo ( count( $students ) != 1 ) ? '<span id="studentsCount">' .count( $students ) . '</span> uczniów' : '<span id="studentsCount">1</span> uczeń' ?> </small></h2>
        <table class="table table-striped" id="students">
            <thead>
                <tr>
                    <?php
                    foreach( $students[0]->toShow() AS $column => $translation ) {
                    ?>
                    <th><?php echo $translation; ?></th>
                    <?
                    }
                    ?>
                    <th>Akcje</th>
                </tr>
            </thead>

            <tbody>
            <?php

            foreach( $students AS $student ) {

            ?>
                <tr id="student_<?php echo $student->id; ?>">
                    <?php
                    foreach( $student->toShow() AS $column => $translation ) {
                    ?>
                        <td id="<?php echo $column; ?>" data-fillable="<?php echo ( in_array(  $column, $student->fillables() ) ) ? 'true' : 'false'; ?>"><?php echo htmlspecialchars( $student->$column ); ?></td>
                    <?
                    }
                    ?>
                    <td>
                        <div id="beforeEdit">
                            <button id="buttonEdit" onClick="editStudent( <?php echo 'student_' . $student->id; ?> );" type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edytuj ucznia">
                                <span class="glyphicon glyphicon-cog"></span>
                            </button>

                            <button onClick="removeStudent( <?php echo $student->id; ?>, '<?php echo csrf_token(); ?>' )" type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Usuń ucznia">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                         </div>


                        <div id="onEdit">
                            <button onClick="saveStudent( <?php echo 'student_' . $student->id; ?>, <?php echo $student->id; ?> )" type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="Zapisz">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>

                            <button onClick="cancelStudent( <?php echo 'student_' . $student->id; ?> )" type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="bottom" title="Anuluj">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>

                    </td>
                </tr>
            <?php

            }

            ?>
            </tbody>
        </table>
    </div>
    <?php

    } else {

    ?>
    <div class="alert alert-danger" id="noStudents"><b>Uwaga!</b> Nie można wyświetlić listy uczniów gdyż jest pusta.</div>
    <?php

    }

    ?>

    <div>
        <h2>Dodawanie ucznia</h2>

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Wypełnij poniższe pola</small></h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" id="addStudentForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control input-sm" placeholder="Imię ucznia">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="surname" class="form-control input-sm" placeholder="Nazwisko ucznia">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="pesel" class="form-control input-sm" placeholder="Pesel ucznia">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="street_address" class="form-control input-sm" placeholder="Adres zamieszkania">
                                    </div>
                                </div>
                            </div>

                            <input type="submit" value="Dodaj" class="btn btn-info btn-block">

                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop