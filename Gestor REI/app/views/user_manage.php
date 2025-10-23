<?php    
    /**
     * Vista de listado de todos los usuarios
     * 
     */
    ob_start();
?>
<div class="contenedor formulario">
    <h2>Lista de Usuarios de <?php echo $instName?></h2>
    <form  method="POST" autocomplete="off">
        <p>
            <label for="jefe">Elige el Jefe:</label>
            <select id="jefe" name="jefe" data-placeholder="Elige un jefe..." multiple data-multi-select selectAll="false" data-max="1" required>

                <?php foreach ($users as $user): ?>
                    <option value="<?php echo $user['Id_Usuario']; ?>"><?php echo $user['Nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="empleados">Elige a los empleados:</label>
            <select id="empleados" name="empleados" data-placeholder="Elige un usuario..." multiple data-multi-select required>
                <?php foreach ($users as $user): ?>
                    <?php if($_SESSION["loginData"]["Id_Usuario"]==$user["Id_Usuario"]):?>
                        <option value="<?php echo $user['Id_Usuario'];?>"><?php echo $user['Nombre'];?></option>
                    <?php else:?>
                        <?php if($user["Privilegios"]!==3):?>
                            <option value="<?php echo $user['Id_Usuario'];?>"><?php echo $user['Nombre'];?></option>
                        <?php endif;?>
                    <?php endif;?>
                <?php endforeach; ?>
            </select>
            <script src="./JS/MultiSelect.js"></script>
        </p>
        <input type="submit" value="Asignar empleados">
    </form>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";