@extends('layouts.layout')

@section('content')


<div class="container margin-top-small">

    <h1>Obecności w dniu <?php echo TranslationHelper::translateDate( $date ); ?></h1>

    <div class="table-responsive">
        <table class="table table-striped" id="students">
            <thead>
            <tr>
                <th>Uczeń / Godzina</th>
                <th class="text-center">1</th>
                <th class="text-center">2</th>
                <th class="text-center">3</th>
                <th class="text-center">4</th>
                <th class="text-center">5</th>
                <th class="text-center">6</th>
                <th class="text-center">7</th>
                <th class="text-center">8</th>

            </tr>
            </thead>

            <tbody>

            <?php
            foreach( $presenceList AS $row ) {
            ?>
            <tr id="student_<?php echo $row->student; ?>">
                <td><?php echo htmlspecialchars( $row->name . ' ' . $row->surname ); ?></td>

                <?php

                    $presence = $row->presence;

                    $presence = explode( ',', $presence );

                    // Fill to 8 elements
                    if( count( $presence ) < 8 ) {
                        for( $i = count( $presence ); $i < 8; $i++ ) {
                            $presence[ $i ] = '';
                        }
                    }

                    foreach( $presence AS $hour => $present ) {
                ?>
                <td class="text-center">
                <?php
                    if( $present == '1' ) {
                    ?>
                    <span class="glyphicon glyphicon-ok"></span>
                    <?php
                    } else if( $present == '0' ) {
                    ?>
                        <span class="glyphicon glyphicon-remove"></span>
                    <?php
                    } else {
                    ?>
                        <div class="btn-group btn-group-xs" id="hour_<?php echo $hour; ?>">
                            <button onClick="setPresent( <?php echo $hour; ?>, <?php echo $row->student; ?>, '<?php echo $date; ?>', 1 )" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Obecny">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>

                            <button onClick="setPresent( <?php echo $hour; ?>, <?php echo $row->student; ?>, '<?php echo $date; ?>', 0 )" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Nieobecny">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>

                    <?php
                    }
                ?>
                </td>
                <?php
                    }
                ?>
            </tr>
            <?php
            }
            ?>

            </tbody>
        </table>
    </div>

    <span class="glyphicon glyphicon-ok"></span> - obecny <span class="glyphicon glyphicon-remove"></span> - nieobecny

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
</div>
@stop