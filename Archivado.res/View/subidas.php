// ! ADAPTAR A LAS SUBIDAS
<!DOCTYPE html>
<html lang="es">
    <?php 
        $nombrePagina="Mis Subidas";
        include 'head.php';
    ?>
    <body>
        <?php include 'cabecera.php'; ?>
        <?php
            // ! Modificar para ver las subidas del usuario
            // foreach($reservas as $reserva){
            //     $cantidades = array_count_values($reserva->getNombreProductos());
            //     $nombresProductos = array_unique($reserva->getNombreProductos());
            //     ?>
            <!-- //         <article class="tarjeta_reserva">
            //             <strong>Productos:</strong>
            //             <div class="productos">
            //                 <?php
            //                     foreach($nombresProductos as $nombreProducto){
            //                         echo '<p>'.$nombreProducto.' X '.$cantidades["$nombreProducto"].'</p>';
            //                     }
            //                 ?>
            //             </div>
            //             <p>Precio:  €</p>    
            //             <a href="../Controller/borrarReserva.php?reserva=">Cancelar Reserva</a>
            //         </article> -->
            <?php
            // }
        ?>
    </body>
</html>