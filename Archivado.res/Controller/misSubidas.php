<?php

    require '../Model/archivo.php';

    session_start();

    if(!isset($_SESSION["usuario"])){
        header('Location: login.php');
        die();
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }

    $archivos = Archivo::getArchivosByAutor($_SESSION["idusuario"]);

    include '../View/subidas.php';
