<?php    
    /**
     * Vista de listado de todas las tareas
     * 
     */
    ob_start();

    if(isset($_COOKIE["status"])){
        switch ($_COOKIE["status"]) {
            case 'creado':
                echo "<p id='mensajeCorrecto' hidden>"."Se ha creado la tarea"."</p>";
                break;
            case 'borrado':
                echo "<p id='mensajeCorrecto' hidden>"."Se ha borrado la tarea"."</p>";
                break;
            case 'mod':
                echo "<p id='mensajeCorrecto' hidden>"."Se ha modificado la tarea"."</p>";
                break;
        }
        setcookie("status", "", time() - 3600, "/");
    }
    
?>
<div class="ajaxTareas">
    <h1>Lista de Tareas</h1>
    <div class="cabeza">
        <a href="index.php?route=task/create">Crear Tarea</a>
        <a href="index.php?route=task/completed">Tareas Completadas</a>
        <a href="index.php?route=task/created">Tareas Creadas</a>
    </div>
    <div class="cuerpo">
        <div class="barra"></i><p class="nombre">Mis Tareas Pendientes</p></div>
        <div id="cuerpo_pendiente" class="visible">
            <div class="ajax">
                <div class="buscador">
                    <input id="buscador" type="text" placeholder="Buscar Tareas Pendientes..." name="ajax"><i id="lupa" class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
            <div id="resultados_busqueda_P" class="invisible"></div>
        </div>
    </div>
    <script src="./JS/Ajax.js"></script>
    <script src="./JS/RecogidaError.js"></script>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";