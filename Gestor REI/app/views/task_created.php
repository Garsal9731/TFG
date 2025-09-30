<?php    
    /**
     * Vista de listado de todas las tareas
     * 
     */
    ob_start();
    var_dump($tasks);
?>
<div class="ajaxTareas">
    <div class="cabeza">
        <h1>Lista de Tareas Creadas</h1>
        <a href="index.php?route=task/create">Crear Tarea</a>
    </div>
    <div class="cuerpo">
        <div class="barra"><i id="completo" class="fa-solid fa-greater-than" onclick="cambiarClase('completo')"></i><p class="nombre">Tareas Creadas</p></div>
        <div id="cuerpo_completo" class="visible">
            <div class="ajax">
                <div class="buscador">
                    <input id="buscador" type="text" placeholder="Buscar Tareas Creadas..." name="ajax"><i id="lupa" class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
            <!-- AÑADIR FUNCIONALIDAD DE AJAX PARA AÑADIR LOS RESULTADOS DE TAREAS CREADAS POR EL USUARIO AQUI -->
            <div id="resultados_busqueda_D" class="invisible"></div>
        </div>
    </div>
    <script src="./JS/Ajax.js"></script>
    <script src="./JS/desplegableTareas.js"></script>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";