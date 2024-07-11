<?php

    session_start();

    // Comprobamos que la session está abierta, de no estarlo se envia al registro
    if(!isset($_SESSION["usuario"])){
        header('Location: login.php');
        die();
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
    }

    // ? Aquí va el sistema de pago

    header('Location: index.php');
    die();