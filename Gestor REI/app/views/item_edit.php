<?php    
    /**
     * Vista de edición de un objeto
     * 
     */
    ob_start();

    // Evita que se guarde la caché de esta página especifica, (Si se guarda las fotos no se actualizan correctamente)
    header('Cache-Control: no-cache');
    header('Pragma: no-cache');
?>
<div class="contenedor formulario">
<h2>Editar Objeto</h2>
<form  method="POST" enctype="multipart/form-data" autocomplete="off">
    <p>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $item['Nombre'];?>" required>
    </p>
    <p>
        <!-- Preseleccionar Estado con el estado anterior en la vista de edición -->
        <label for="estado">Estado Objeto:</label>
        <select name="estado">
            <option value="Alta">Alta</option>
            <option value="Baja">Baja</option>
            <option value="Inactivo">Inactivo</option>
            <option value="Averiado">Averiado</option>
            <!-- AÑADIR CON JS QUE SI LE DA A AVERIADO APARECE EL CUADRO CON LA DESCRIPCION DE LA AVERIA -->
        </select>
    </p>
    <p>
        <!-- AÑADIR LIMITE DE CARACTERES EN TEXTAREA PARA QUE CONCUERDE CON EL MAXIMO DE LA BD -->
        <label for="descAveria">Descripción Avería:</label>
        <textarea name="descAveria"><?php echo $item["Descripción_Avería"];?></textarea>
    </p>
    <?php if($item["Foto"]!=="no"){?>
        <div class="fotos">
        <p>
            <label for="fotoObjeto">Foto actual objeto:</label>
            <img  name="fotoObjeto" class="fotoObjeto" src="IMG/items/<?php echo $item["Foto"]?>" alt="Foto Objeto">
        </p>
    <?php };?>
    <p>
        <label for="foto">Foto Objeto:</label>
        <input type="file" id="foto" name="foto" accept="image/*" />
    </p>
    <?php if($item["Foto"]!=="no"){?>
        </div>
    <?php };?>
    <input type="hidden" id="fotoAnt" name="fotoAnt" value="<?php echo $item["Foto"]?>">
    <input type="submit" value="Editar Objeto">
</form>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";