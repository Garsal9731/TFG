<!DOCTYPE html>
<html lang="es">
    <?php 
        $nombrePagina="Login";
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
        <form action="../Controller/registrarProducto.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <p><img id="preview" src="#" alt="Preview Foto Nueva" width="300" height="300"/></p>
            <p>
                <label for="file">Foto del producto:</label>
                <input type="file" name="file" id="file" accept="image/*" onchange="loadFile(event)" required>
            </p>
            <p>
                <label for="nombre">Nombre del producto:</label>
                <input type="nombre" name="nombre" id="nombre" placeholder="Nombre" required>
            </p>
            <p>
                <label for="precio">Precio del producto:</label>
                <!-- Añadimos step para poder añadir decimales a la cifra -->
                <input type="number" name="precio" id="precio" step="0.01" placeholder="Precio" required>
            </p>
            <p>
                <label for="unidades">Unidades disponibles:</label>
                <input type="number" name="unidades" id="unidades" placeholder="Unidades" required>
            </p>
            <p>
                <label for="descripcion">Descripción del producto:</label>
                <textarea name="descripcion" cols="60" rows="6"></textarea>
            </p>
            <input type="submit" name="registrar" id="registrar" value="Registrar Producto">
        </form>
    </body>
</html>