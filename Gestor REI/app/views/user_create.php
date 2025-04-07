<?php    
    /**
     * Vista de creación de usuario
     * 
     */
    ob_start();
?>
    
<h2>Crear Usuario</h2>
<form  method="POST">
    <label for="name">Nombre:</label>
    <input type="text" name="name" required>
    <input type="submit" value="Crear Usuario">
</form>
    
<?php
    $content = ob_get_clean();
    require 'layouts/main.php';
?>