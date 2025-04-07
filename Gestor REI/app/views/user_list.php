<?php    
    /**
     * Vista de listado de todos los usuarios
     * 
     */
    ob_start();
    ?>
    
    <h2>Lista de Usuarios</h2>
    <a href="index.php?route=user/create">Crear Usuario</a>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php echo $user['name']; ?>
                <a href="index.php?route=user/edit&id=<?php echo $user['id']; ?>">Editar</a>
                <a href="index.php?route=user/delete&id=<?php echo $user['id']; ?>">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <?php
    $content = ob_get_clean();
    require "layouts/main.php";