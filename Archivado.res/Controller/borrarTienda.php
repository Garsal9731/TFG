<?php

    // ! NO CAMBIADO
    include '../Model/tienda.php';

    $tienda = new Tienda($_GET["idtienda"],"",0,"");
    $tienda->eliminar();

    header('Location: index.php');
    die();