<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../View/estilos.css">
        <title>Carrito</title>
    </head>
    <body>
        <?php include 'cabecera.php';?>
        <div class="grid_carrito">
        <?php
            foreach($arrayCarrito as $idProducto){
                $producto = Producto::getProductoById($idProducto);
            ?>
                <article class="tarjeta_producto">
                <h3><?=$producto->getNombre()?></h3>
                    <img src="<?=$producto->getFoto();?>">
                    <p>Precio: <?=$producto->getPrecio();?> €</p>
                    <p>Cantidad: <?=$cantidades[$idProducto];?></p>
                    <p>Precio Completo (todas las unidades en carrito): <?=$producto->getPrecio() * $cantidades[$idProducto];?> €</p>
                    <?php
                        $precioTotal += $producto->getPrecio() * $cantidades[$idProducto];
                        echo '<div class="mas_menos">';
                            echo '<a class="menos" href="../Controller/quitarCarrito.php?producto='.$producto->getId().'">-</a>';
                            echo '<a class="mas" href="../Controller/comprar.php?producto='.$producto->getId().'">+</a>';
                        echo '</div>';    
                        echo '<p><a href="../Controller/quitarTodosCarrito.php?producto='.$producto->getId().'">Quitar Todos</a></p>';
                    ?>
                </article>
            <?php
            }
        ?>
        </div>
        <h3>Precio Total de la Compra: <?=$precioTotal?>€</h3>
        <?php
            if(count($_SESSION["carrito"])>0){
                echo '<a href="../Controller/reservar.php"><button>Reservar</button></a>';
                echo '<a href="../Controller/pagar.php"><button>Pagar</button></a>';
            }
        ?>
    </body>
</html>