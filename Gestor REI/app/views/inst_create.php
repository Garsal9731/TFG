<?php    
    /**
     * Vista de creación de instituciones
     * 
     */
    ob_start();
?>
<div class="contenedor">
    <h2>Crear Institucion</h2>
    <form class="inst" method="POST" autocomplete="off">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" placeholder="Nombre de la institución..." id="nombre" name="nombre" required>
        </p>
        <p class="botonesForm">
            <input type="submit" value="Crear Institución">
            <a class="cancelar" href="index.php?route=inst/index">Cancelar</a>
        </p>
    </form>
</div> 
<?php
    $content = ob_get_clean();
    include 'layouts/main.php';
