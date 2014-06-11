<?php
$pageTitle = 'Obecności';
?>
@extends('layouts.layout')

@section('content')


<div class="container margin-top-small">
    <?php
    if( $presence->first() ) {
    ?>
    <div class="table-responsive">

        <h1>Obecności <?php echo htmlspecialchars( ucfirst( strtolower( $student->name ) ) . ' ' . ucfirst( strtolower( $student->surname ) ) ) ?></h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Dzień / Godzina</th>
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

            foreach( $presence AS $key => $presenceModel ) {
            ?>
            <tr>

                <td><?php echo TranslationHelper::translateDate( $presenceModel->date ); ?></td>

                <?php

                $pres = $presenceModel->presence;

                $pres = explode( ',', $pres );

                // Fill to 8 elements
                if( count( $pres ) < 8 ) {
                    for( $i = count( $pres ); $i < 8; $i++ ) {
                        $pres[ $i ] = '';
                    }
                }

                foreach( $pres AS $hour => $present ) {
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
                                <button onClick="setPresent( <?php echo $hour; ?>, <?php echo $presenceModel->student_id; ?>, '<?php echo $presenceModel->date; ?>', 1, '<?php echo URL::to( '/presence/set' ) ?>' )" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Obecny">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </button>

                                <button onClick="setPresent( <?php echo $hour; ?>, <?php echo $presenceModel->student_id; ?>, '<?php echo $presenceModel->date; ?>', 0, '<?php echo URL::to( '/presence/set' ) ?>' )" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Nieobecny">
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

        <span class="glyphicon glyphicon-ok"></span> - obecny <span class="glyphicon glyphicon-remove"></span> - nieobecny

        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

    </div>
    <?php
    } else {
    ?>
    <h1>Ten uczeń jeszcze nie był obecny!</h1>
    <?php
    }
    ?>
</div>
@stop