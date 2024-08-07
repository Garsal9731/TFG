<!DOCTYPE html>
<html lang="es">
    <?php 
        $nombrePagina="Nueva Subida";
        include 'head.php';
    ?>
    <body>
        <?php include 'cabecera.php';?>
        <script>
            var loadFile = function(event){

                // Recogemos el elemento preview que ya hemos creado en el html
                var preview = document.getElementById('preview');

                // URL de subida de la imagen
                preview.src = URL.createObjectURL(event.target.files[0]);

                // Si carga la imagen borramos el objeto de memoria para evitar tiempo de carga
                preview.onload = function() {
                    URL.revokeObjectURL(preview.src);
                }
            };
        </script>
        <form action="../Controller/validarSubidas.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <p><img id="preview" src="#" alt="Preview Foto Nueva" width="300" height="300"/></p>
            <p>
                <label for="archivos">Archivo a subir:</label>
                <input type="file" name="archivos[]" id="archivos" onchange="loadFile(event)" required multiple>
            </p>
            <!-- <p>
                <label for="nombre">Nombre:</label>
                <input type="nombre" name="nombre" id="nombre" placeholder="Nombre" required>
            </p>
            <p>
                <label for="unidades">Unidades disponibles:</label>
                <input type="number" name="unidades" id="unidades" placeholder="Unidades" required>
            </p>
            <p>
                <label for="descripcion">Descripción del producto:</label>
                <textarea name="descripcion" cols="60" rows="6"></textarea>
            </p> -->
            <input type="submit" name="registrar" id="registrar" value="Subir Archivos">
        </form>
    </body>
</html>