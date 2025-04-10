<?php    
    /**
     * Vista de edición de una tarea
     * 
     */
    ob_start();
?>

<?php
    $content = ob_get_clean();
    require "layouts/main.php";