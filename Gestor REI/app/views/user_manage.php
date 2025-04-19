<?php    
    /**
     * Vista de listado de todos los usuarios
     * 
     */
    ob_start();
    // ! CREAR CHECKEO PARA REVISAR SI EL USUARIO SELECCIONADO YA ES JEFE DE CADA 1 DE LOS OTROS USUARIOS
?>

<h2>Lista de Usuarios de <?php echo $instName?></h2>
<form  method="POST" autocomplete="off">
    <p>
        <label for="jefe">Elige el Jefe:</label>
        <select name="jefe">
            <option value="" disabled selected>Elige un Jefe</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['Id_Usuario']; ?>"><?php echo $user['Nombre']; ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label for="empleados">Elige a los empleados:</label>
            <?php foreach ($users as $user): ?>
                <?php if($_SESSION["loginData"]["Id_Usuario"]==$user["Id_Usuario"]):?>
                    <input type="checkbox" name="empleado[]" value="<?php echo $user['Id_Usuario']; ?>" disabled/>
                    <label for="empleado[]"><?php echo $user['Nombre']; ?></label>
                <?php else:?>
                    <?php if($user["Privilegios"]!==3):?>
                        <input type="checkbox" name="empleado[]" value="<?php echo $user['Id_Usuario']; ?>" />
                        <label for="empleado[]"><?php echo $user['Nombre']; ?></label>
                    <?php endif;?>
                <?php endif;?>
            <?php endforeach; ?>
    </p>
    <input type="submit" value="Asignar empleados">
</form>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";