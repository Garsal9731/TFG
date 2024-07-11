<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../View/estilos.css">
        <title>Detalles de tienda</title>
    </head>
    <body>
        <?php include 'cabecera.php'; ?>
        <h2><?=$tienda->getNombre();?></h2>
        <p><?=$tienda->getDescripcion();?></p>
        <h4>Productos Disponibles:</h4>
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
                        if($producto["unidades"]>0){
                            echo '<a href="../Controller/comprar.php?producto='.$producto["idproducto"].'">Añadir al carrito</a>';
                        } 
                    ?>
                </article>
            <?php
            }
        ?>
        </div>
    </body>
</html>