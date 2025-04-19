<?php    
    /**
     * Vista de listado de todas las tareas
     * 
     */
    ob_start();
?>
    
<h2>Lista de Tareas</h2>
<a href="index.php?route=task/create">Crear Tarea</a>
<ul>
    <?php foreach ($tasks as $task): ?>
        <li>
            <?php echo  ucfirst($task['Nombre_Tarea']); ?>
            <a href="index.php?route=task/edit&id=<?php echo $task['Id_Tarea']; ?>">Editar</a>
            <a href="index.php?route=task/delete&id=<?php echo $task['Id_Tarea']; ?>">Eliminar</a>
        </li>
    <?php endforeach; ?>
</ul>
    
<?php
    $content = ob_get_clean();
    require "layouts/main.php";