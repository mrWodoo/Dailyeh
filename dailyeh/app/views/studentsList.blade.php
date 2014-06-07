@extends('layouts.layout')

@section('content')


<div class="container margin-top-small">
    <?php

    if( count( $students) ) {

    ?>
    <div>
        <h2>Lista uczniów</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>Dodano</th>
                    <th>Ostatnia aktualizacja</th>
                    <th>Akcje</th>
                </tr>
            </thead>

            <tbody>
            <?php

            foreach( $students AS $student ) {

            ?>
                <tr id="student_<?php echo $student->id; ?>">
                    <td id="studentName"><?php echo $student->name; ?></td>
                    <td id="student_surname"><?php echo $student->surname; ?></td>
                    <td><?php echo $student->created_at; ?></td>
                    <td><?php echo $student->updated_at; ?></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edytuj ucznia">
                            <span class="glyphicon glyphicon-cog"></span>
                        </button>

                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Usuń ucznia">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
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
    <div class="alert alert-danger"><b>Uwaga!</b> Nie można wyświetlić listy uczniów gdyż jest pusta.</div>
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
                        <form role="form">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control input-sm" placeholder="Imię ucznia">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="surname" class="form-control input-sm" placeholder="Nazwisko ucznia">
                                    </div>
                                </div>
                            </div>

                            <input type="submit" value="Dodaj" class="btn btn-info btn-block">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop