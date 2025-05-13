<?php    
    /**
     * Vista de creación de usuario
     * 
     */
    ob_start();
?>
<div class="contenedor">
    <h2>Crear Usuario</h2>
    <form  method="POST" autocomplete="off">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
        </p>
        <p>
            <!-- AÑADIR EXPRESION REGULAR PARA CORREO -->
            <label for="correo">Correo:</label>
            <input type="text" name="correo" required>
        </p>
        <p>
            <!-- AÑADIR BOTON DE MOSTRAR CON JS -->
            <label for="contra">Contraseña:</label>
            <input type="password" name="contra" required>
        </p>
        <p>
            <!-- Preseleccionar Estado con el estado anterior en la vista de edición -->
            <label for="privilegios">Tipo de usuario:</label>
            <select name="privilegios">
                <option value="1">Admin</option>
                <option value="2">Técnico</option>
                <option value="3">Usuario</option>
            </select>
        </p>
        <input type="submit" value="Crear Usuario">
    </form>
</div> 
<?php
    $content = ob_get_clean();
    require 'layouts/main.php';
