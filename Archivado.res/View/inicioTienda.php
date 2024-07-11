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
            <script>
                function buscarProducto(hilo) {
                    if(hilo.length == 0){ 
                        document.getElementById("resultados_busqueda").innerHTML = "";
                        return;
                    }else{
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function() {
                            if(this.readyState == 4 && this.status == 200){
                                document.getElementById("resultados_busqueda").innerHTML = this.responseText;
                            }
                        }
                        xmlhttp.open("GET", "../Controller/ajaxProductos.php?peticion="+hilo, true);
                        xmlhttp.send();
                    }
                }
            </script>
            <div class="buscador">
                <h1>¡Busca tus productos aqui!</h1>
                <form action="" autocomplete="off">
                    <input type="text" name="ajax" onkeyup="buscarProducto(this.value)">
                </form>
                <p>Resultados: <span id="resultados_busqueda"></span></p>
            </div>
            <div class="grid">
            <?php
                foreach($data['productos'] as $producto)  {
                ?>
                    <article class="tarjeta_producto">
                        <h3><?=$producto->getNombre()?></h3>
                        <img src="<?=$producto->getFoto();?>">
                        <p>Precio: <?=$producto->getPrecio();?> €</p>
                        <p>Unidades: <?=$producto->getUnidades();?></p>
                        <a href="../Controller/detallesTienda.php?idtienda=<?=$producto->getTienda()?>"><?=$producto->getNombreTienda()?></a>
                        <?php 
                            if($producto->getUnidades()>0){
                                echo '<a href="../Controller/comprar.php?producto='.$producto->getId().'">Añadir al carrito</a>';
                            }
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