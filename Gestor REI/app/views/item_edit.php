<?php    
    /**
     * Vista de edición de un objeto
     * 
     */
    // ! RELLENAR CON LOS CAMPOS RESTANTES Y EMPEZAR CON LA CREACIÓN DE LAS TAREAS
    ob_start();
?>
<h2>Editar Objeto</h2>
<form method="POST" autocomplete="off">
    <input type="text" name="nombre" value="<?php echo $item['Nombre']; ?>" required />
    <button type="submit">Guardar</button>
</form>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";