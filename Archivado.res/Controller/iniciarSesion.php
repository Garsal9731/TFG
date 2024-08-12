<?php

    session_start();

    require '../Model/usuario.php';
    $usuario = new Usuario(0,$_POST["nombre"],$_POST["contra"],0,"correo","descripcion");

    if($usuario->validarUsuario()){
        $_SESSION["usuario"] = serialize($usuario);
        $_SESSION["privilegio"] = $usuario->getPriv();
        $_SESSION["idusuario"] = $usuario->getId();
        header('Location: index.php');
        die();
    }else{
        header('Location: login.php');
        die();
    }
    
    