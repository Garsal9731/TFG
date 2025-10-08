<?php    
    /**
     * Vista de listado de todos los usuarios
     * 
     */
    ob_start();
    if(isset($_COOKIE["status"])){
        switch ($_COOKIE["status"]) {
            case 'creado':
                echo "<p id='mensajeError' hidden>"."Se ha registrado al usuario"."</p>";
                break;
            case 'borrado':
                echo "<p id='mensajeError' hidden>"."Se ha dado de baja al usuario"."</p>";
                break;
            case 'mod':
                echo "<p id='mensajeError' hidden>"."Se ha modificado el usuario"."</p>";
                break;
            case 'asignado':
                echo "<p id='mensajeError' hidden>"."Se ha asignado el usuario"."</p>";
                break;
        }
        setcookie("status", "", time() - 3600, "/");
    }
?>
    <div class="ajax">
        <h1>Usuarios</h1>
        <div class="ajax">
            <div class="buscador">
                <input id="buscador" type="text" placeholder="Buscar Usuario..." name="ajax"><i id="lupa" class="fa-solid fa-magnifying-glass"></i>
            </div>
            <a href="index.php?route=user/create">Registrar Usuario</a>
        </div>
        <div id="resultados_busqueda" class="invisible"></div>
    </div>
    <script src="./JS/Ajax.js"></script>
    <script src="./JS/RecogidaError.js"></script>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";