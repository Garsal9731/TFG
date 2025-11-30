<?php    
    /**
     * Vista de estadisticas del usuario
     * 
     */
    ob_start();
?>
    <script src="./JS/generateChart.js"></script>
    <div class="stats">
        <div id="chart_div"></div>
        <div class="chart_body">
            <a href="index.php?route=user/edit&id=<?php echo $_GET["id"]?>">Editar Usuario</a>
            <!-- CREAR PARA VER TODAS LAS TAREAS DEL USUARIO QUE SE ESTÁ VIENDO -->
            <a href="index.php?route=task/all&id=<?php echo $_GET["id"]?>">Ver Tareas</a>
        </div>
    </div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";