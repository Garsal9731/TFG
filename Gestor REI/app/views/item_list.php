<?php    
    /**
     * Vista de listado de todos los objetos
     * 
     */
    ob_start();
?>
    
<h2>Lista de Objetos</h2>
<a href="index.php?route=item/create">Crear Objeto</a>
<ul>
    <?php foreach ($items as $item): ?>
        <li>
            <?php echo $item['Nombre']; ?>
            <a href="index.php?route=item/edit&id=<?php echo $item['Id_Usuario']; ?>">Editar</a>
            <a href="index.php?route=item/delete&id=<?php echo $item['Id_Usuario']; ?>">Eliminar</a>
        </li>
    <?php endforeach; ?>
</ul>
    
<?php
    $content = ob_get_clean();
    require "layouts/main.php";