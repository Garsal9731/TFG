<?php    
    /**
     * Vista de Revisión de una tarea
     * 
     */
    ob_start();
?>
<div class="contenedor formulario">
    <h2>Revisar Tarea</h2>
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
            <select id="empleados" name="empleados" data-placeholder="Elige un usuario..." multiple data-multi-select required>
                <?php foreach ($employees as $employee): ?>
                    <option value="<?php echo $employee['Id_Usuario'];?>" selected><?php echo $employee['Nombre'];?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="fechaEstimada">Fecha Estimada para terminar:</label>
            <input type="datetime-local" name="fechaEstimada" min="<?php echo date("Y-m-d")."T".date("h:i");?>" value="<?php echo str_replace(" ","T",substr($task["Tiempo_Estimado"],0,16));?>"required>
        </p>
    </form>
</div>
<script src="./JS/MultiSelect.js"></script>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";