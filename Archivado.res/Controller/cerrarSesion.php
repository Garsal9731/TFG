<?php

    // ! NO CAMBIADO
    session_start();

    if(!isset($_SESSION["usuario"])){
        header('Location: registro.php');
        die();
    }
    if(isset($_COOKIE["idUsuario"])){
        setcookie('idUsuario', '', -1, '/');
    }

    session_destroy();

    header('Location: login.php');
    die();