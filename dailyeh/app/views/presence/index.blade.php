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
            <h2><?php echo TranslationHelper::translateMonth( $month ); ?></h2>
            <?php

            foreach( $days AS $day => $data ) {

            ?>
            <ul>
                <li>
                    <h2><?php echo $day; ?></h2>
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