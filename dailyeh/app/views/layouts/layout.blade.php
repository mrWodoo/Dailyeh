<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap -->
    <link href="{{ URL::asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta charset="utf-8">
    <title>Logowanie do systemu</title>

<?php if( isset( $loginPage ) ) { ?>
    <link href="{{ URL::asset('css/login.css') }}" rel="stylesheet">
<?php } else { ?>
    <link href="{{ URL::asset('css/main.css') }}" rel="stylesheet">
<?php } ?>
    <!-- Ubuntu font -->
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&amp;subset=Latin">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<?php if( !isset( $loginPage ) ) { ?>
    <div class="container header">
        <div class="row">
            <div class="col-md-3">
                <h1>Dziennik ucznia</h1>
            </div>

            <div class="col-md-8 header-icons">

                <a href="{{URL::to('/')}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Strona Główna">
                    <span class="glyphicon glyphicon-home"></span>
                </a>

                <a href="{{URL::to('/students')}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Uczniowie">
                    <span class="glyphicon glyphicon-user"></span>
                </a>

                <a href="{{URL::to('/')}}" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Obecności">
                    <span class="glyphicon glyphicon-time"></span>
                </a>

                <a href="{{URL::to('/logout')}}/<?php echo csrf_token(); ?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="Wyloguj się">
                    <span class="glyphicon glyphicon-log-out"></span>
                </a>

            </div>
        </div>
    </div>
<?php } ?>

@yield('content')

<div class="container">
    <hr>
    <small>&copy; <a href="mailto:denis.wrobel420@gmail.com">Denis Wróbel</a></small> |
    <small><span class="glyphicon glyphicon-cog"></span> <?php echo memory_get_usage( true) / 1024 / 1024 ?> MiB</small>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ URL::asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/main.js') }}"></script>


</body>
</html>