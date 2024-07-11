<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../View/estilos.css">
        <title>Perfil Usuario</title>
    </head>
    <body>
        <?php include 'cabecera.php'; ?>
        <h1><?=ucfirst($usuario->getNombre());?></h1>
        <p>Correo de Contacto: <?=$usuario->getCorreo();?></p>
        <h2>Tiendas de <?=ucfirst($usuario->getNombre());?>:</h2>
        <?php
            foreach($tiendas as $tienda){
            ?>
                <article class="tarjeta_tienda">
                    <h3><?=$tienda["nombre"];?></h3>
                    <p><?=$tienda["descripcion"]?></p>
                    <?php echo '<a href="../Controller/detallesTienda.php?idtienda='.$tienda["idtienda"].'">Más detalles.</a>';?>
                </article>
            <?php
            }
            ?>
    </body>
</html>