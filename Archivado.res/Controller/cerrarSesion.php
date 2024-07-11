<?php

    session_start();

    if(!isset($_SESSION["usuario"])){
        header('Location: registro.php');
        die();
    }

    session_destroy();

    header('Location: login.php');
    die();