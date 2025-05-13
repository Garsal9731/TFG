<?php    
    /**
     * Vista inicial general
     * 
     */
    ob_start();
?>

<div class="contenedor">
    <h2>Bienvenido <?php echo ucfirst($_SESSION["loginData"]["Nombre"]);?></h2>
    <h1>VISTA INDEX GENERAL</h1>
    
    <script src="./JS/Ajax.js"></script>
    <div class="ajax">
        <h1>Ajax</h1>
        <form action="" autocomplete="off">
            <input id="buscador" type="text" name="ajax">
        </form>
        <p class="resultados">Resultados: <div id="resultados_busqueda"></div></p>
    </div>

</div>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";