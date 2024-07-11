<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../View/estilos.css">
        <title>Panel Admin</title>
    </head>
    <body>
        <?php include 'cabecera.php';?>
        <script>
            function buscarProducto(hilo) {
                if(hilo.length == 0){ 
                    document.getElementById("resultados_busqueda_productos").innerHTML = "";
                    return;
                }else{
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if(this.readyState == 4 && this.status == 200){
                            document.getElementById("resultados_busqueda_productos").innerHTML = this.responseText;
                        }
                    }
                    xmlhttp.open("GET", "../Controller/ajaxProductos.php?peticion="+hilo, true);
                    xmlhttp.send();
                }
            }
            function buscarUsuario(hilo) {
                if(hilo.length == 0){ 
                    document.getElementById("resultados_busqueda_usuarios").innerHTML = "";
                    return;
                }else{
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if(this.readyState == 4 && this.status == 200){
                            document.getElementById("resultados_busqueda_usuarios").innerHTML = this.responseText;
                        }
                    }
                    xmlhttp.open("GET", "../Controller/ajaxUsuarios.php?peticion="+hilo, true);
                    xmlhttp.send();
                }
            }
        </script>
        <div class="separador_admin">
            <div class="parte_usuarios">
                <div class="buscador">
                    <h1>Buscar usuarios:</h1>
                    <form action="" autocomplete="off">
                        <input type="text" name="ajax" onkeyup="buscarUsuario(this.value)">
                    </form>
                    <p>Resultados Usuarios: <span id="resultados_busqueda_usuarios"></span></p>
                </div>
                <?php
                    foreach($data['usuarios'] as $usuario){
                    ?>
                    <article class="tarjeta_usuario">
                        <h3><?=$usuario->getNombre()?></h3>
                        <p>Id Usuario: <?=$usuario->getId()?></p>
                        <p>Correo: <?=$usuario->getCorreo()?></p>
                        <p>Privilegios: <?=$usuario->getPrivilegio()?></p>
                        <a href="../Controller/darBajaUsuario.php?id=<?=$usuario->getId()?>">Dar de baja</a>
                    </article>
                    <?php
                    }
                ?>
            </div>
            <div class="parte_productos">
                <div class="buscador">
                    <h1>Buscar productos:</h1>
                    <form action="" autocomplete="off">
                        <input type="text" name="ajax" onkeyup="buscarProducto(this.value)">
                    </form>
                    <p>Resultados Productos: <span id="resultados_busqueda_productos"></span></p>
                </div>
                <div class="grid_productos_admin">
                    <?php
                        foreach($data['productos'] as $producto){
                            ?>
                            <article class="tarjeta_producto">
                                <h3><?=$producto->getNombre()?></h3>
                                <p><?=$producto->getDescripcion()?></p>
                                <img src="<?=$producto->getFoto()?>">
                                <p>Unidades: <?=$producto->getUnidades()?></p>
                                <p>Precio: <?=$producto->getPrecio()?>€</p>
                                <a href="../Controller/detallesTienda.php?idtienda=<?=$producto->getTienda()?>"><?=$producto->getNombreTienda()?></a>
                                <a href="../Controller/borrarProducto.php?idproducto=<?=$producto->getId()?>">Borrar Producto</a>
                            </article>
                        <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>