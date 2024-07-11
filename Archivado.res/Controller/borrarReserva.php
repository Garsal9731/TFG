<?php

    require '../Model/reserva.php';

    $reserva = Reserva::getReservaById($_GET["reserva"]);
    $productos = $reserva->getProductos();
    foreach($productos as $producto){
        Producto::aumentarStock($producto);
    }
    $reserva->eliminar();

    header("Location: misReservas.php");
    die();