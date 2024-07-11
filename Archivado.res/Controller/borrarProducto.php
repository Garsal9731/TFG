<?php

    include '../Model/producto.php';

    $producto = Producto::getProductoById($_GET["idproducto"]);
    $producto->borrar();

    header('Location: index.php');
    die();