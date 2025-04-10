<?php    
    /**
     * Vista de creación de tarea
     * 
     */
    ob_start();
?>

<?php
    $content = ob_get_clean();
    require "layouts/main.php";