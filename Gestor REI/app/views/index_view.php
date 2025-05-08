<?php    
    /**
     * Vista inicial general
     * 
     */
    ob_start();
?>

<h2>Bienvenido <?php echo ucfirst($_SESSION["loginData"]["Nombre"]);?></h2>
<h1>VISTA INDEX GENERAL</h1>

<label for="ejemplo">Ejemplo select multiple:</label>
<select id="ejemplo" name="ejemplo" data-placeholder="Elige un usuario" multiple data-multi-select>
<?php foreach ($users as $user): ?>
    <option value="<?php echo $user['Nombre'];?>"><?php echo $user['Nombre'];?></option>
<?php endforeach; ?>
</select>
<script src="./JS/MultiSelect.js"></script>

<script src="./JS/Ajax.js"></script>
            <div>
                <h1>Ajax</h1>
                <form action="" autocomplete="off">
                    <input type="text" name="ajax" onkeyup="buscarProducto(this.value)">
                </form>
                <p>Resultados: <span id="resultados_busqueda"></span></p>
            </div>
<?php
    $content = ob_get_clean();
    require "layouts/main.php";