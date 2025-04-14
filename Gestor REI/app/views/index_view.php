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

<h2>Lista de Tareas</h2>
<a href="index.php?route=task/create">Crear Tarea</a>
<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <?php echo $task['Nombre']; ?>
            <a href="index.php?route=task/edit&id=<?php echo $task['Id_Tarea']; ?>">Editar</a>
            <a href="index.php?route=task/delete&id=<?php echo $task['Id_Tarea']; ?>">Eliminar</a>
        </li>
    <?php endforeach; ?>
</ul>
    
<h2>Lista de Objetos</h2>
<a href="index.php?route=item/create">Crear Objeto</a>
<ul>
    <?php foreach ($items as $item): ?>
        <li>
            <?php echo $item['Nombre']; ?>
            <a href="index.php?route=item/edit&id=<?php echo $item['Id_Objeto']; ?>">Editar</a>
            <a href="index.php?route=item/delete&id=<?php echo $item['Id_Objeto']; ?>">Eliminar</a>
        </li>
    <?php endforeach; ?>
</ul>
<a href="index.php?route=core/logoff">Cerrar Sesión</a>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";