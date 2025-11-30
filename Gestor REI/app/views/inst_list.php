<?php    
    /**
     * Vista de Instituciones
     * 
     */
    ob_start();
    if(isset($_COOKIE["status"])){
        if($_COOKIE["status"]=="creado") {
            echo "<p id='mensajeCorrecto' hidden>"."Se ha creado la institución"."</p>";
        }elseif($_COOKIE["status"]=="borrado"){
            echo "<p id='mensajeCorrecto' hidden>"."Se ha borrado la institución"."</p>";
        }
        setcookie("status", "", time() - 3600, "/");
    }
?>
    <div class="ajax">
        <h1>Instituciones</h1>
        <div class="ajax">
            <div class="buscador">
                <input id="buscador" type="text" placeholder="Buscar Institución..." name="ajax"><i id="lupa" class="fa-solid fa-magnifying-glass"></i>
            </div>
            <a href="index.php?route=inst/create">Registrar Institución</a>
        </div>
        <div id="resultados_busqueda" class="invisible"></div>
    </div>
    <script src="./JS/Ajax.js"></script>
    <script src="./JS/RecogidaError.js"></script>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";