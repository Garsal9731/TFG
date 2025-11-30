<?php    
    /**
     * Vista de edición de una tarea
     * 
     */
    ob_start();
?>
<div class="contenedor formulario">

<?php
    $content = ob_get_clean();
    include "layouts/main.php";