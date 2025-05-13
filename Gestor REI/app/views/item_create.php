<?php    
    /**
     * Vista de creación de objetos
     * 
     */
    ob_start();
?>
<div class="contenedor">
    <h2>Crear Objeto</h2>
    <form  method="POST" autocomplete="off">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
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
            <label for="descAveria">Descripción Avería:</label>
            <textarea name="descAveria"></textarea>
        </p>
        <input type="submit" value="Crear Objeto">
    </form>
</div>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";