<?php    
    /**
     * Vista de creación de tarea
     * 
     */
    ob_start();
?>
<div class="contenedor formulario">
    <h2>Crear Tarea</h2>
    <form  method="POST" autocomplete="off">
        <p>
            <label for="nombreTarea">Nombre:</label>
            <input type="text" placeholder="Nombre de la Tarea..." id="nombreTarea" name="nombreTarea" required>
        </p>
        <p>
            <label for="detalles">Detalles Tarea:</label>
            <textarea placeholder="Escribe detalles de la tarea..." id="detalles" name="detalles"></textarea>
        </p>
        <p>
            <label>Elige a los encargados:</label>
            <select id="empleados" name="empleados" data-placeholder="Elige un usuario..." multiple data-multi-select required>
                <?php foreach ($employees as $employee): ?>
                    <option value="<?php echo $employee['Id_Usuario'];?>"><?php echo $employee['Nombre'];?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="fechaEstimada">Fecha Estimada para terminar:</label>
            <input type="date" id="fechaEstimada" onmousedown="this.showPicker()" name="fechaEstimada" min="<?php echo date("Y-m-d");?>" required>
        </p>
        <p class="estadoTarea">
            <label for="estado">Estado de la tarea:</label>
            <select id="estado" name="estado">
                <option value="Pendiente">Pendiente</option>
                <option value="Completada">Completada</option>
            </select>
        </p>
        <input type="submit" value="Crear Tarea">
    </form>
</div>
<script src="./JS/MultiSelect.js"></script>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";