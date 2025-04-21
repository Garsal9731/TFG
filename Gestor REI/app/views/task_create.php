<?php    
    /**
     * Vista de creación de tarea
     * 
     */
    ob_start();
?>
<h2>Crear Tarea</h2>
<form  method="POST" autocomplete="off">
    <p>
        <label for="nombreTarea">Nombre:</label>
        <input type="text" name="nombreTarea" required>
    </p>
    <p>
        <label for="detalles">Detalles Tarea:</label>
        <textarea name="detalles"></textarea>
    </p>
    <p>
        <label for="empleados">Elige a los encargados:</label>
            <?php foreach ($employees as $employee): ?>
                <input type="checkbox" name="empleado[]" value="<?php echo $employee['Id_Usuario']; ?>" />
                <label for="empleado[]"><?php echo $employee['Nombre']; ?></label>
            <?php endforeach; ?>
    </p>
    <p>
        <label for="fechaEstimada">Fecha Estimada para terminar:</label>
        <input type="datetime-local" name="fechaEstimada" min="<?php echo date("Y-m-d")."T".date("h:i");?>" required>
    </p>
    <input type="submit" value="Crear Tarea">
</form>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";