<?php    
    /**
     * Vista de listado de todos las tareas
     * 
     */
    ob_start();
?>

<?php
    $content = ob_get_clean();
    require "layouts/main.php";