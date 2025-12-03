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
        <p>
            <label for="contra">Contraseña Usuario:</label>
            <input type="password" id="contra" name="contra" onkeyup="revisar()"/>
        </p>
        <p>
            <label for="contracon">Confirmar Contraseña Usuario:</label>
            <input type="password" id="contracon" name="contracon" onkeyup="revisar()"/>
        </p>
        <p class="botonesForm">
            <input type="submit" id="guardar" value="Guardar" disabled></input>
            <a class="cancelar" href="index.php?route=user/index">Cancelar</a>
        </p>
    </form>
</div>
<script src="JS/pass.js"></script>
<?php
    $content = ob_get_clean();
    include 'layouts/main.php';
