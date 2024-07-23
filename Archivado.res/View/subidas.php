<!-- ! ADAPTAR A LAS SUBIDAS -->
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../View/estilos.css">
        <title>Mis Reservas</title>
    </head>
    <body>
        <?php include 'cabecera.php'; ?>
        <?php
            foreach($reservas as $reserva){
                $cantidades = array_count_values($reserva->getNombreProductos());
                $nombresProductos = array_unique($reserva->getNombreProductos());
                ?>
                    <article class="tarjeta_reserva">
                        <strong>Productos:</strong>
                        <div class="productos">
                            <?php
                                foreach($nombresProductos as $nombreProducto){
                                    echo '<p>'.$nombreProducto.' X '.$cantidades["$nombreProducto"].'</p>';
                                }
                            ?>
                        </div>
                        <p>Precio: <?=$reserva->getPrecio();?> €</p>    
                        <a href="../Controller/borrarReserva.php?reserva=<?=$reserva->getId();?>">Cancelar Reserva</a>
                    </article>
            <?php
            }
        ?>
    </body>
</html>