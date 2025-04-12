<?php    
    /**
     * Vista inicial general
     * 
     */
    ob_start();
?>
<h1>VISTA INDEX GENERAL</h1>
<a href="index.php?route=user/index">Indíce Usuario</a>
<a href="index.php?route=item/index">Indíce Objeto</a>
<a href="index.php?route=task/index">Indíce Tarea</a>

<h2>Lista de Usuarios</h2>
<a href="index.php?route=user/create">Crear Usuario</a>
<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?php echo $user['Nombre']; ?>
            <a href="index.php?route=user/edit&id=<?php echo $user['Id_Usuario']; ?>">Editar</a>
            <a href="index.php?route=user/delete&id=<?php echo $user['Id_Usuario']; ?>">Eliminar</a>
        </li>
    <?php endforeach; ?>
</ul>
    
<?php
    $content = ob_get_clean();
    require "layouts/main.php";