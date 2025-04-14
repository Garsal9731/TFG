<?php    
    /**
     * Vista de creación de tarea
     * 
     */
    ob_start();
    // ! RECOGER ID DEL USUARIO ACTUAL PARA REGISTRARLO COMO CREADOR DE TAREA
    // ! CREAR UN SELECT CON LOS USUARIOS QUE SE HAN ASIGNADO COMO QUE SON EMPLEADOS DEL ACTUAL
    // ! AÑADIR UN SELECTOR DE FECHAS PARA CONSEGIR LA EL TIEMPO ESTIMADO (restando la fecha de finalización con la actual)
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
    <input type="submit" value="Crear Tarea">
</form>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";