<?php    
    /**
     * Vista de edición de usuario
     * 
     */
    ob_start();
?>
    
<h2>Editar Usuario</h2>
<form method="POST" autocomplete="off">
    <input type="text" name="nombre" value="<?php echo $user['Nombre']; ?>" required />
    <button type="submit">Guardar</button>
</form>
    
<?php
    $content = ob_get_clean();
    require 'layouts/main.php';
