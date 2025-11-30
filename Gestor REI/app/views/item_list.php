<?php    
    /**
     * Vista de listado de todos los objetos
     * 
     */
    ob_start();
        if(isset($_COOKIE["status"])){
        switch ($_COOKIE["status"]) {
            case 'creado':
                echo "<p id='mensajeCorrecto' hidden>"."Se ha creado el objeto"."</p>";
                break;
            case 'borrado':
                echo "<p id='mensajeCorrecto' hidden>"."Se ha borrado el objeto"."</p>";
                break;
            case 'mod':
                echo "<p id='mensajeCorrecto' hidden>"."Se ha editado el objeto"."</p>";
                break;
            case 'fmov':
                echo "<p id='mensajeError' hidden>"."No se ha podido mover la foto"."</p>";
                break;
            case 'fsub':
                echo "<p id='mensajeError' hidden>"."No se ha podido subir la foto"."</p>";
                break;
        }
        setcookie("status", "", time() - 3600, "/");
    }
?>
    <div class="ajax">
        <h1>Objetos</h1>
        <div class="ajax">
            <div class="buscador">
                <input id="buscador" type="text" placeholder="Buscar Objeto..." name="ajax"><i id="lupa" class="fa-solid fa-magnifying-glass"></i>
            </div>
            <a href="index.php?route=item/create">Crear Objeto</a>
        </div>
        <div id="resultados_busqueda" class="Robjeto invisible"></div>
    </div>
    <script src="./JS/Ajax.js"></script>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";