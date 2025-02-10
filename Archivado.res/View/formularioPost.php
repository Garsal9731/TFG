<!DOCTYPE html>
<html lang="es">
    <?php 
        $nombrePagina="Formulario ";
        include 'head.php';
    ?>
    <body>
        <?php include 'cabecera.php'; ?>
        <form action="../Controller/guardarPost.php" method="POST" autocomplete="off">
            <p>
                <label for="nombre_post">Titulo del Post:</label>
                <input type="text" name="nombre_post">
            </p>
            <p>  
                <label for="tipo_contenido">Tipo De Contenido:</label>
                <select name="tipo_contenido" required>
                    <option value="" selected disabled hidden>Escoge el tipo de contenido</option>
                    <option value="multimedia">Multimedia</option>
                    <option value="audio">Audio</option>
                    <option value="imagen">Imagen</option>
                    <option value="programa">Programa</option>
                    <option value="otro">Otro Formato</option>
                </select>
            </p>
            <p>
                <label for="detalles">Detalles:</label>
                <textarea name="detalles" required></textarea>
            </p>
            <p>
                <label for="autor_original">Autor Original:</label>
                <input type="text" name="autor_original">
            </p>
            <p>
                <input type="submit" name="registrar" value="Crear Post">
            </p>
      </form>
    </body>
</html>