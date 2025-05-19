<?php    
    /**
     * Vista de edición de una tarea
     * 
     */
    ob_start();
    // ! AÑADIR NUEVO CAMPO Y AÑADIR EL MULTISELECT A ESTA PAGINA
?>
<div class="contenedor">
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
                <?php foreach ($employees as $employee): ?>
                    <?php if(in_array($employee["Id_Usuario"],$idsAssigned)):?>
                        <input type="checkbox" name="empleado[]" value="<?php echo $employee['Id_Usuario']; ?>" checked/>
                        <label for="empleado[]"><?php echo $employee['Nombre']; ?></label>
                    <?php else:?>
                        <input type="checkbox" name="empleado[]" value="<?php echo $employee['Id_Usuario']; ?>"/>
                        <label for="empleado[]"><?php echo $employee['Nombre']; ?></label>
                    <?php endif; ?>
                <?php endforeach; ?>
        </p>
        <p>
            <label for="fechaEstimada">Fecha Estimada para terminar:</label>
            <input type="datetime-local" name="fechaEstimada" min="<?php echo date("Y-m-d")."T".date("h:i");?>" value="<?php echo str_replace(" ","T",substr($task["Tiempo_Estimado"],0,16));?>"required>
        </p>
        <input type="submit" value="Modificar Tarea">
    </form>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";