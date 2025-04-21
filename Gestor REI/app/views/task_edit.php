<?php    
    /**
     * Vista de edición de una tarea
     * 
     */
    ob_start();
    // ! COMPROBAR QUE FUNCIONA LA EDICIÓN
?>
<h2>Modificar Tarea</h2>
<form  method="POST" autocomplete="off">
    <p>
        <label for="nombreTarea">Nombre:</label>
        <input type="text" name="nombreTarea" value="<?php echo $task["Nombre_Tarea"]?>"required>
    </p>
    <p>
        <label for="detalles">Detalles Tarea:</label>
        <textarea name="detalles"><?php echo $task["Detalles"]?></textarea>
    </p>
    <p>
        <label for="empleados">Elige a los encargados:</label>
            <?php foreach ($employees as $employee): 
                // ! NO RECOGE LOS USUARIOS
                ?>
                <input type="checkbox" name="empleado[]" value="<?php echo $employee['Id_Usuario']; ?>" checked/>
                <label for="empleado[]"><?php echo $employee['Nombre']; ?></label>
            <?php endforeach; ?>
    </p>
    <p>
        <label for="fechaEstimada">Fecha Estimada para terminar:</label>
        <input type="datetime-local" name="fechaEstimada" min="<?php echo date("Y-m-d")."T".date("h:i");?>" value="<?php echo str_replace(" ","T",substr($task["Tiempo_Estimado"],0,16));?>"required>
    </p>
    <input type="submit" value="Crear Tarea">
</form>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";