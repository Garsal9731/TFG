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
        <script>
            function buscarTienda(hilo){
                if(hilo.length == 0){ 
                    document.getElementById("resultados_busqueda").innerHTML = "";
                    return;
                }else{
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function(){
                        if(this.readyState == 4 && this.status == 200){
                            document.getElementById("resultados_busqueda").innerHTML = this.responseText;
                        }
                    }
                    xmlhttp.open("GET", "../Controller/ajaxTiendas.php?peticion="+hilo, true);
                    xmlhttp.send();
                }
            }
        </script>
        <main>
            <div class="buscador">
                <h1>¡Busca tus tiendas aquí!</h1>
                <form action="" autocomplete="off">
                    <input type="text" name="ajax" onkeyup="buscarTienda(this.value)">
                </form>
                <p>Resultados: <span id="resultados_busqueda"></span></p>
            </div>
            <?php
                foreach($data['tiendas'] as $tienda)  {
                ?>
                    <article class="tarjeta_tienda">
                        <h3><?=$tienda->getNombre()?></h3>
                        <p><?=$tienda->getDescripcion()?></p>
                        <?php

                            $usuario = $tienda::getPropietarioById($tienda->getPropietario());
                            echo 'Proveedor: <a href="../Controller/recogerId.php?idPerfil='.$usuario["idusuario"].'">'.$usuario["nombre"].'</a>';
                            echo '<p><a href="../Controller/detallesTienda.php?idtienda='.$tienda->getId().'">Ver detalles.</a></p>';
                        ?>
                    </article>
                <?php
                }
            ?>
        </main>
        <footer>

        </footer>
    </body>
</html>