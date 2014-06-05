<?php
$loginPage = true;
?>
@extends('layouts.layout')

@section('content')
    <div class="container">
        <form class="form-signin" role="form" method="POST">
            @if ( $loginProcessed and $loginFailed )
            <div class="alert alert-danger">Złe dane logowania!</div>
            @endif

            @if ( $loggedOut )
            <div class="alert alert-success">Wylogowałeś się!</div>
            @endif

            <h2 class="form-signin-heading">Zaloguj się</h2>
            <input type="text" class="form-control" placeholder="Login administratora" name="login" required autofocus>
            <input type="password" class="form-control" placeholder="Hasło" name="password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Zaloguj się</button>


        </form>

    </div>
@stop