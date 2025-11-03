<?php    
    /**
     * Vista de listado de todas las tareas
     * 
     */
    ob_start();
?>
<div class="ajaxTareas">
    <h1>Lista de Tareas Creadas</h1>
    <div class="cabeza">
        <a href="index.php?route=task/create">Crear Tarea</a>
        <a href="index.php?route=task/completed">Tareas Completadas</a>
        <a href="index.php?route=task/created">Tareas Creadas</a>
    </div>
    <div class="cuerpo">
        <div class="barra"><i id="creado" class="fa-solid fa-greater-than rotado" onclick="cambiarClase('creado')"></i><p class="nombre">Tareas Creadas</p></div>
        <div id="cuerpo_creado" class="visible">
            <div class="ajax">
                <div class="buscador">
                    <input id="buscador" type="text" placeholder="Buscar Tareas Creadas..." name="ajax"><i id="lupa" class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
            <div id="resultados_busqueda_D" class="invisible"></div>
        </div>
    </div>
    <script src="./JS/Ajax.js"></script>
    <script src="./JS/desplegableTareas.js"></script>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";