<?php
$pageTitle = 'Obecności';
?>
@extends('layouts.layout')

@section('content')


<div class="container margin-top-small">
    <?php
    foreach( $dates AS $year => $months ) {
    ?>

    <h1>Rok <?php echo $year; ?></h1>
    <ul>

    <?php

    foreach( $months AS $month => $days ) {

    ?>
        <li>
            <h2><a href="#" onclick="showDays( '<?php echo 'date-' . $year . '-' . $month; ?>' );"><?php echo TranslationHelper::translateMonth( $month ); ?></a></h2>
            <ul id="<?php echo 'date-' . $year . '-' . $month; ?>" style="display: none;">
            <?php

            foreach( $days AS $day => $data ) {

            ?>

                <li>
                    <h3>
                        <a href="<?php echo URL::route( 'presenceView', array( $year . '-' . $month . '-' . $day ) ); ?>">
                        <?php echo $day; ?>
                        <?php
                        if( !isset( $data['hadPresence'] ) || !$data['hadPresence'] ) {
                        ?>
                            <small><span class="label label-danger">Nieuzupełnione obecności</span></small>
                        <?php
                        }
                        ?>
                        </a>
                    </h3>
                </li>
            <?php

            }

            ?>
            </ul>
        </li>
    <?php

    }

    ?>
    </ul>
    <?php

    }

    ?>
</div>
@stop