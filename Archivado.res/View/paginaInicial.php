<!DOCTYPE html>
<html lang="es">
    <?php 
        $nombrePagina="Inicio";
        include 'head.php';
    ?>
    <body>
        <?php include 'cabecera.php'; ?>
        <main>
            <!-- <script>
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
            </div> -->
            <div class="grid">

            </div>
        </main>
        <footer>

        </footer>
    </body>
</html>