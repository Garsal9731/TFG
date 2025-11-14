<?php    
    /**
     * Vista inicial general
     * 
     */
    ob_start();
?>
<div class="banner">
    <div class="fondo">
        <i class="fa-solid fa-crown"></i>
        <h3>¡Bienvenido al Gestor REI!</h3>
        <p>El Gestor REI consiste en un gestor de inventariado y tareas. Gracias al cual puedes organizar a tus empleados o llevar la cuenta de que objetos se encuentran en el inventario de tu empresa y/o institución.</p>
    </div>
</div>
<form class="login" method="POST" autocomplete="off">
    <p>
        <label for="Correo">Correo:</label>
        <input type="email" id="Correo" name="correo" placeholder="Correo" onkeyup="Comprobar(this.value,'Correo')" autofocus required>
    </p>
    <p>
        <label for="contra">Contraseña:</label>
        <input type="password" id="contra" name="contra" placeholder="Contraseña" required>
    </p>
    <input type="submit" value="Iniciar Sesión">
</form>
<script src="./JS/Regexp.js"></script>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";