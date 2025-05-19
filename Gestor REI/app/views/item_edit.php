<?php    
    /**
     * Vista de edición de un objeto
     * 
     */
    // ! RELLENAR CON LOS CAMPOS RESTANTES Y EMPEZAR CON LA CREACIÓN DE LAS TAREAS
    ob_start();
?>
<div class="contenedor">
<h2>Editar Objeto</h2>
<form  method="POST" autocomplete="off">
    <p>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $item['Nombre'];?>" required>
    </p>
    <p>
        <!-- Preseleccionar Estado con el estado anterior en la vista de edición -->
        <label for="estado">Estado Objeto:</label>
        <select name="estado">
            <option value="Alta">Alta</option>
            <option value="Baja">Baja</option>
            <option value="Inactivo">Inactivo</option>
            <option value="Averiado">Averiado</option>
            <!-- AÑADIR CON JS QUE SI LE DA A AVERIADO APARECE EL CUADRO CON LA DESCRIPCION DE LA AVERIA -->
        </select>
    </p>
    <p>
        <!-- AÑADIR LIMITE DE CARACTERES EN TEXTAREA PARA QUE CONCUERDE CON EL MAXIMO DE LA BD -->
        <label for="descAveria">Descripción Avería:</label>
        <textarea name="descAveria"><?php echo $item["Descripción_Avería"];?></textarea>
    </p>
    <input type="submit" value="Editar Objeto">
</form>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";