<?php    
    /**
     * Vista de Instituciones
     * 
     */
    ob_start();
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
<?php
    $content = ob_get_clean();
    include "layouts/main.php";