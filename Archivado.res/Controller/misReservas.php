<?php

    require '../Model/reserva.php';

    session_start();

    if(!isset($_SESSION["usuario"])){
        header('Location: login.php');
        die();
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }

    $reservas = Reserva::getReservasByUsuario($_SESSION["idusuario"]);

    include '../View/reservas.php';
