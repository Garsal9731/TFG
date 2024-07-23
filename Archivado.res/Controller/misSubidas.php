<?php

    require '../Model/usuario.php';

    session_start();

    if(!isset($_SESSION["usuario"])){
        header('Location: login.php');
        die();
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }


    include '../View/subidas.php';
