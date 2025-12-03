<?php    
    /**
     * Vista de creación de objetos
     * 
     */
    ob_start();
?>
<div class="contenedor formulario">
    <h2>Crear Objeto</h2>
    <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <p>
            <label for="nombre">Nombre:</label>
            <input type="text" placeholder="Nombre del objeto..." id="nombre" name="nombre" required>
        </p>
        <p>
            <label for="estado">Estado Objeto:</label>
            <select id="estado" name="estado" required>
                <option value="Alta">Alta</option>
                <option value="Baja">Baja</option>
                <option value="Inactivo">Inactivo</option>
                <option value="Averiado">Averiado</option>
            </select>
        </p>
        <p>
            <label for="descAveria">Descripción Avería:</label>
            <textarea id="descAveria" placeholder="Escribe en detalle la avería..." name="descAveria"></textarea>
        </p>
        <p>
            <label for="foto">Foto Objeto:</label>
            <input type="file" id="foto" name="foto" accept="image/*" />
        </p>
        <p class="botonesForm">
            <input type="submit" value="Crear Objeto">
            <a class="cancelar" href="index.php?route=item/index">Cancelar</a>
        </p>
    </form>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";