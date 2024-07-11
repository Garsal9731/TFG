<?php

    require '../Model/usuario.php';

    if($_POST["privilegio"]=="on"){
        $privilegio = 1;
    }else{
        $privilegio = 0;
    }

    $contra = password_hash($_POST["contra"], PASSWORD_DEFAULT);
    
    $usuario = new Usuario("0",$_POST["nombre"],$contra,$privilegio,$_POST["correo"]);

    $usuario->registrar();

    header("Location: login.php");
    die();
