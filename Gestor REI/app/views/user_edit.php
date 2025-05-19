<?php    
    /**
     * Vista de edición de usuario
     * 
     */
    ob_start();
?>
<div class="contenedor">
    <h2>Editar Usuario</h2>
    <form method="POST" autocomplete="off">
        <p>
            <label for="nombre">Nombre Usuario:</label>
            <input type="text" name="nombre" value="<?php echo $user['Nombre']; ?>" required />
        </p>
        <p>
            <label for="correo">Correo Usuario:</label>
            <input type="text" name="correo" value="<?php echo $user['Correo']; ?>" disabled />
        </p>
        <!-- COMPROBAR QUE LAS CONTRASEÑA COINCIDEN CON JS -->
        <p>
            <label for="contra">Contraseña Usuario:</label>
            <input type="password" name="contra" />
        </p>
        <p>
            <label for="contracon">Confirmar Contraseña Usuario:</label>
            <input type="password" name="contracon" />
        </p>
        <button type="submit">Guardar</button>
    </form>
</div>
<?php
    $content = ob_get_clean();
    include 'layouts/main.php';
