<?php

    session_start();

    require '../Model/usuario.php';

    $usuario = new Usuario("0",$_POST["nombre"],$_POST["contra"],"0","correo");
    
    if($usuario->validarUsuario()){
        $_SESSION["usuario"] = serialize($usuario);
        $_SESSION["privilegio"] = $usuario->getPrivilegio();
        $_SESSION["idusuario"] = $usuario->getId();
        $_SESSION["carrito"] = array();
        header('Location: index.php');
        die();
    }else{
        header('Location: login.php');
        die();
    }
    
    