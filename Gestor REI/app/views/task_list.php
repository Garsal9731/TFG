<?php    
    /**
     * Vista de listado de todos las tareas
     * 
     */
    ob_start();
?>
<h1>TAREAS</h1>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";