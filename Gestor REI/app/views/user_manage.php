<?php    
    /**
     * Vista de listado de todos los usuarios
     * 
     */
    ob_start();
?>

<h2>Lista de Usuarios de <?php echo $instName?></h2>
<form  method="POST" autocomplete="off">
    <p>
        <label for="Jefe">Elige el Jefe:</label>
        <select name="Jefe">
            <option value="" disabled selected>Elige un Jefe</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['Id_Usuario']; ?>"><?php echo $user['Nombre']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label for="empleados">Elige a los empleados:</label>
        <!-- <select name="empleados"> -->
            <!-- <option value="" disabled selected>Elige un Jefe</option> -->
            <?php foreach ($users as $user): ?>
                <?php if($_SESSION["loginData"]["Id_Usuario"]==$user["Id_Usuario"]):?>
                    <!-- <option value="<?php echo $user['Id_Usuario']; ?>" disabled><?php echo $user['Nombre']; ?></option> -->
                    <input type="checkbox" name="empleado[]" value="<?php echo $user['Id_Usuario']; ?>" disabled/>
                    <label for="empleado[]"><?php echo $user['Nombre']; ?></label>
                <?php else:?>
                    <!-- <option value="<?php echo $user['Id_Usuario']; ?>"><?php echo $user['Nombre']; ?></option> -->
                    <input type="checkbox" name="empleado[]" value="<?php echo $user['Id_Usuario']; ?>" />
                    <label for="empleado[]"><?php echo $user['Nombre']; ?></label>
                <?php endif;?>
            <?php endforeach; ?>
        <!-- </select> -->
    </p>
    <input type="submit" value="Asignar empleados">
</form>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";