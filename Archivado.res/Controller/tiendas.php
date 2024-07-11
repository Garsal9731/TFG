<?php

    require '../Model/tienda.php';

    session_start();

    if(!isset($_SESSION["usuario"])){
        $privilegio = 2;
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }

    $data['tiendas'] = Tienda::getTiendas();

    include '../View/listaTiendas.php';