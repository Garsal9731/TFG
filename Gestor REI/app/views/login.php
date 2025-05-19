<?php    
    /**
     * Vista inicial general
     * 
     */
    ob_start();
?>

<form class="login" method="POST" autocomplete="off">
    <p>
        <label for="correo">Correo:</label>
        <input type="email" id="Correo" name="correo" placeholder="Correo" onkeyup="Comprobar(this.value,'Correo')" required>
    </p>
    <p>
        <label for="contra">Contraseña:</label>
        <input type="password" name="contra" placeholder="Contraseña" required>
    </p>
    <input type="submit" value="Iniciar Sesión">
</form>
<script src="./JS/Regexp.js"></script>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";