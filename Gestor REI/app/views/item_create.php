<?php    
    /**
     * Vista de creación de objetos
     * 
     */
    ob_start();
?>

<?php
    $content = ob_get_clean();
    require "layouts/main.php";