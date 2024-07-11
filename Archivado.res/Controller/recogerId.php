<?php

    session_start();

    if(isset($_GET["idproducto"])){
        $_SESSION["productoEditar"] = $_GET["idproducto"];
        header('Location: editarProducto.php');
        die();
    }

    if(isset($_GET["idPerfil"])){
        $_SESSION["idPerfil"] = $_GET["idPerfil"];
        header('Location: perfilUsuario.php');
        die();
    }
