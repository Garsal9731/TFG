<?php

    require '../Model/usuario.php';

    session_start();

    // Comprobamos que la session está abierta, de no estarlo se envia al registro
    if(!isset($_SESSION["usuario"])){
        $privilegio = 2;
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }
    include '../View/paginaInicial.php';