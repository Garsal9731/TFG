<?php

    require '../Model/reserva.php';

    session_start();
    
    $cantidades = array_count_values($_SESSION["carrito"]);
    $arrayCarrito = $_SESSION["carrito"];

    sort($arrayCarrito);

    foreach($arrayCarrito as $idProducto){
        $producto = Producto::getProductoById($idProducto);
        $precioTotal += $producto->getPrecio() * $cantidades[$idProducto];
        Producto::reducirStock($idProducto);
    }

    $productos = implode($arrayCarrito);
    //  ? El hilo productos se puede usar como un array

    $reserva = new Reserva(0,$_SESSION["idusuario"],$productos,$precioTotal);
    $reserva->registrar();

    $_SESSION["carrito"] = [];

    header('Location: misReservas.php');
    die();