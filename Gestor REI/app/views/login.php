<?php    
    /**
     * Vista inicial general
     * 
     */
    ob_start();
?>

<form  method="POST" autocomplete="off">
    <p>
        <label for="correo">Correo:</label>
        <input type="text" name="correo" required>
    </p>
    <p>
        <label for="contra">Contraseña:</label>
        <input type="password" name="contra" required>
    </p>
    <input type="submit" value="Iniciar Sesión">
</form>

<?php
    $content = ob_get_clean();
    require "layouts/main.php";