<?php    
    /**
     * Vista de listado de relaciones de todos los usuarios
     * 
     */
    ob_start();
    if(isset($_COOKIE["status"])){
        switch ($_COOKIE["status"]) {
            case 'asignado':
                echo "<p id='mensajeError' hidden>"."Se han establecido los permisos"."</p>";
                break;
            case 'borrado':
                echo "<p id='mensajeError' hidden>"."Se han eliminado los permisos"."</p>";
                break;
            case 'fallo':
                echo "<p id='mensajeError' hidden>"."No se ha podido asignar al usuario"."</p>";
                break;
        }
        setcookie("status", "", time() - 3600, "/");
    }
?>
    <div class="ajax">
        <h1>Permisos</h1>
        <h3>¡Mira que usuario manda a que otro usuario!</h3>
        <div class="ajax">
            <div class="buscador">
                <input id="buscador" type="text" placeholder="Buscar Permisos..." name="ajax"><i id="lupa" class="fa-solid fa-magnifying-glass"></i>
            </div>
            <a href="index.php?route=user/permits">Registrar Permisos</a>
        </div>
        <div id="resultados_busqueda" class="invisible"></div>
    </div>
    <script src="./JS/Ajax.js"></script>
    <script src="./JS/RecogidaError.js"></script>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";