<?php    
    /**
     * Vista de listado de todos los objetos
     * 
     */
    ob_start();
?>

<?php
    $content = ob_get_clean();
    require "layouts/main.php";