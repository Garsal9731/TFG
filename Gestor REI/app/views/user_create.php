<?php    
    /**
     * Vista de creación de usuario
     * 
     */
    ob_start();
?>
<div class="contenedor formulario">
    <h2>Crear Usuario</h2>
    <form  method="POST" autocomplete="off">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" placeholder="Nombre del usuario..." id="nombre" name="nombre" required>
        </p>
        <p>
            <label for="correo">Correo:</label>
            <input type="text" placeholder="Correo del usuario..." id="correo" name="correo" required>
        </p>
        <p>
            <label for="contra">Contraseña:</label>
            <input type="password" placeholder="Contraseña del usuario..." id="contra" name="contra" required>
        </p>
        <p>
            <label for="privilegios">Tipo de usuario:</label>
            <select id="privilegios" name="privilegios">
                <option value="1">Admin</option>
                <option value="2">Técnico</option>
                <option value="3">Usuario</option>
            </select>
        </p>
        <?php if($_SESSION["loginData"]["Privilegios"]==4){?>
            <p>
                <label for="institucion">Institucion del usuario:</label>
                <select name="institucion" id="institucion">
                    <?php foreach($insts as $inst){?>
                        <option value="<?php echo $inst["Id_Institución"]?>"><?php echo $inst["Nombre_Institución"]?></option>
                    <?php }?>
                </select>
            </p>
        <?php }?>
        <p class="botonesForm">
            <input type="submit" value="Crear Usuario">
            <a class="cancelar" href="index.php?route=user/index">Cancelar</a>
        </p>
    </form>
</div> 
<?php
    $content = ob_get_clean();
    include 'layouts/main.php';
