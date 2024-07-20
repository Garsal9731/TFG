<?php

    // ! NO CAMBIADO
    require '../Model/producto.php';

    session_start();

    $cantidades = array_count_values($_SESSION["carrito"]);

    $stock = Producto::getStock($_GET["producto"]);
    $cantidades = array_count_values($_SESSION["carrito"]);
    $stockCarrito = $cantidades[$_GET["producto"]];

    if($stockCarrito<$stock){
        // Guardamos la id del objeto en el carrito
        array_push($_SESSION["carrito"],$_GET["producto"]);
    }

    header('Location: carrito.php');
    die();
    