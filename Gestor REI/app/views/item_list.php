<?php    
    /**
     * Vista de listado de todos los objetos
     * 
     */
    ob_start();
?>
<div class="contenedor">
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
</div>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";