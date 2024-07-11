<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../View/estilos.css">
        <title>TiendaDeTiendas</title>
    </head>
    <body>
        <?php include 'cabecera.php'; ?>
        <main>
            <div class="grid">
            <?php
                foreach($productos as $producto){
                ?>
                    <article class="tarjeta_producto">
                        <h3><?=$producto["nombre"]?></h3>
                        <p><?=$producto["descripcion"]?></p>
                        <img src="<?=$producto["rutafoto"]?>">
                        <p>Unidades: <?=$producto["unidades"]?></p>
                        <p>Precio: <?=$producto["precio"]?>€</p>
                        <?php 
                            echo '<a href="../Controller/borrarProducto.php?idproducto='.$producto["idproducto"].'">Borrar Producto</a>';
                            echo '<a href="../Controller/recogerId.php?idproducto='.$producto["idproducto"].'">Editar Producto</a>';
                        ?>
                    </article>
                <?php
                }
            ?>
            </div>
        </main>
        <footer>

        </footer>
    </body>
</html>