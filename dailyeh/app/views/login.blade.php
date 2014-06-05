<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap -->
    <link href="{{ URL::asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta charset="utf-8">
    <title>Logowanie do systemu</title>

    <link href="{{ URL::asset('css/login.css') }}" rel="stylesheet">

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

    <div class="container">
        <form class="form-signin" role="form" method="POST">
            @if ( $loginProcessed and $loginFailed )
            <div class="alert alert-danger">Złe dane logowania!</div>
            @endif

            <h2 class="form-signin-heading">Zaloguj się</h2>
            <input type="text" class="form-control" placeholder="Login administratora" name="login" required autofocus>
            <input type="password" class="form-control" placeholder="Hasło" name="password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj się</button>


        </form>

    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ URL::asset('bootstrap/js/bootstrap.min.js') }}"></script>

</body>
</html>