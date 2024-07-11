<?php

    include '../Model/tienda.php';

    $tienda = new Tienda(0,$_POST["nombre"],$_GET["idusuario"],$_POST["descripcion"]);

    $tienda->registrar();

    header('Location: index.php');
    die();