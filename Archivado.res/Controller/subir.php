<?php

    require '../Model/usuario.php';

    session_start();

    // Comprobamos que la session está abierta, de no estarlo se envia al registro
    if(!isset($_SESSION["usuario"])){
        header('Location: login.php');
        die();
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
    }

    // ! PROBAR CON CAMBIAR LAS COOKIES POR SESSIONES
    if(isset($_COOKIE["nombresTemporales"])){
        setcookie("nombresTemporales",'',-1, "/");
    }
    if(isset($_COOKIE["idsAnalisis"])){
        setcookie("idsAnalisis",'',-1, "/");    
    }
    if(isset($_COOKIE["nombresOriginales"])){
        setcookie("nombresOriginales",'',-1, "/");
    }
    if(isset($_COOKIE["idsArchivos"])){
        setcookie("idsArchivos",'',-1, "/");
    }

    include '../View/formularioSubida.php';