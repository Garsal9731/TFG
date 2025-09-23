<?php    
    /**
     * Vista de listado de todas las tareas
     * 
     */
    ob_start();
?>
<div class="ajaxTareas">
    <div class="cabeza">
        <h1>Lista de Tareas</h1>
        <a href="index.php?route=task/create">Crear Tarea</a>
        <!-- !COLOCAR UNA FUNCIÓN AL CONTROLADOR DE TASK QUE REDIRIJA A NUEVA VISTA CON LAS TAREAS COMPLETADAS Y OTROS CON LAS CREADAS -->
        <a href="index.php?route=task/completed">Tareas Completadas</a>
    </div>
    <div class="cuerpo">
        <div class="barra"><i id="pendiente" class="fa-solid fa-greater-than rotado" onclick="cambiarClase('pendiente')"></i><p class="nombre">Tareas Pendientes</p></div>
        <div id="cuerpo_pendiente" class="visible">
            <div class="ajax">
                <div class="buscador">
                    <input id="buscador" type="text" placeholder="Buscar Tareas Pendientes..." name="ajax" onkeyup="buscarAjax(this.value,'TareaP')"><i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
            <div id="resultados_busqueda_P" class="invisible"></div>
        </div>
        <!-- <div class="barra"><i id="completo" class="fa-solid fa-greater-than" onclick="cambiarClase('completo')"></i><p class="nombre">Tareas Completadas</p></div>
        <div id="cuerpo_completo">
            <div class="ajax">
                <div class="buscador">
                    <input id="buscador" type="text" placeholder="Buscar Tareas Completadas..." name="ajax" onkeyup="buscarAjax(this.value,'TareaC')"><i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
            <div id="resultados_busqueda_C" class="invisible"></div>
        </div> -->
    </div>
    <script src="./JS/Ajax.js"></script>
    <script src="./JS/desplegableTareas.js"></script>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";