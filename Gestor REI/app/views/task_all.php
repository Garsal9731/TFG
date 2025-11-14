<?php    
    /**
     * Vista de listado de todas las tareas
     * 
     */
    ob_start();    
?>
<div class="ajaxTareas">
    <h1>Lista de Tareas de <?php echo $_SESSION["loginData"]["Nombre"];?></h1>
    <div class="cabeza">
        <a href="index.php?route=task/create">Crear Tarea</a>
        <a href="index.php?route=task/completed">Tareas Completadas</a>
        <a href="index.php?route=task/created">Tareas Creadas</a>
    </div>
    <div class="cuerpo">
        <div class="barra"><p class="nombre">Tareas <?php echo $_SESSION["loginData"]["Nombre"];?></p></div>
        <div id="cuerpo_pendiente" class="visible">
            <div class="ajax">
                <div class="buscador">
                    <input id="buscador" type="text" placeholder="Buscar Tareas..." name="ajax"><i id="lupa" class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
            <div id="resultados_busqueda_U" class="invisible"></div>
        </div>
    </div>
</div>
<script src="./JS/Ajax.js"></script>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";