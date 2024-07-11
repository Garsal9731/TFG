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
            
            <?php
                foreach($tiendas as $tienda)  {
                ?>
                    <!-- ! AÑADIR PAGINA PARA VER LA TIENDA Y SUS PRODUCTOS -->
                    <article class="tarjeta_tienda">
                        <h3><?=$tienda["nombre"]?></h3>
                        <p><?=$tienda["descripcion"]?></p>
                        <a href="../Controller/borrarTienda.php?idtienda=<?=$tienda["idtienda"]?>">Dar de baja</a>
                        <a href="../Controller/detallesTienda.php?idtienda=<?=$tienda["idtienda"]?>">Ver Tienda</a>

                    </article>
                <?php
                }
            ?>
        </main>
        <footer>

        </footer>
    </body>
</html>