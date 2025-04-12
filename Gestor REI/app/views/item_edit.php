<?php    
    /**
     * Vista de edición de un objeto
     * 
     */
    ob_start();
?>

<?php
    $content = ob_get_clean();
    require "layouts/main.php";