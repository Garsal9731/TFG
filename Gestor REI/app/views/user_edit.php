<?php    
    /**
     * Vista de edición de usuario
     * 
     */
    ob_start();
    ?>
    
    <h2>Editar Usuario</h2>
    <form method="POST">
        <input type="text" name="name" value="<?php echo $user['name']; ?>" required />
        <button type="submit">Guardar</button>
    </form>
    
    <?php
    $content = ob_get_clean();
    require 'layouts/main.php';
    ?>