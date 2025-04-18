<?php    
    /**
     * Vista inicial general
     * 
     */
    ob_start();
?>

<h2>Bienvenido <?php echo ucfirst($_SESSION["loginData"]["Nombre"]);?></h2>
<h1>VISTA INDEX GENERAL</h1>
<a href="index.php?route=user/index">Indíce Usuario</a>
<a href="index.php?route=item/index">Indíce Objeto</a>
<a href="index.php?route=task/index">Indíce Tarea</a>
<?php if($_SESSION["loginData"]["Privilegios"]==1){?>
    <h2>Lista de Usuarios</h2>
    <a href="index.php?route=user/create">Crear Usuario</a>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php echo ucfirst($user['Nombre']);?>
                <a href="index.php?route=user/edit&id=<?php echo $user['Id_Usuario']; ?>">Editar</a>
                <a href="index.php?route=user/delete&id=<?php echo $user['Id_Usuario']; ?>">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php }?>

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

<?php if($_SESSION["loginData"]["Privilegios"]==1 || $_SESSION["loginData"]["Privilegios"]==2){?>
    <h2>Lista de Objetos</h2>
    <a href="index.php?route=item/create">Crear Objeto</a>
    <ul>
        <?php foreach ($items as $item): ?>
            <li>
                <?php echo "{$item['Nombre']} Estado:{$item['Estado']} Avería:{$item['Descripción_Avería']}"; ?>
                <a href="index.php?route=item/edit&id=<?php echo $item['Id_Objeto']; ?>">Editar</a>
                <a href="index.php?route=item/delete&id=<?php echo $item['Id_Objeto']; ?>">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php }?>
<?php if($_SESSION["loginData"]["Privilegios"]==1){?>
    <h2>Lista de Empleados</h2>
    <ul>
        <?php foreach ($employees as $employee): ?>
            <li>
                <?php echo ucfirst($employee['Nombre']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <p>
        <a href="index.php?route=user/manage">Manejar Empleados</a>
    </p>
<?php }?>

<p>
    <a href="index.php?route=core/logoff">Cerrar Sesión</a>
</p>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";