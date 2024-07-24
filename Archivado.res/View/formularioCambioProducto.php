<!DOCTYPE html>
<html lang="es">
    <?php 
        $nombrePagina="Registrar Producto";
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
        <form action="../Controller/actualizarProducto.php" method="POST" enctype="multipart/form-data" autocomplete="off">
            <?php echo '<img src="'.$producto->getFoto().'">'; ?>
            <p>
                <label for="file">Foto del producto:</label>
                <input type="file" name="file" id="file" accept="image/*" onchange="loadFile(event)">
            </p>
            <p><img id="preview" src="#" alt="Preview Foto Nueva" width="300" height="300"/></p>
            <p>
                <label for="nombre">Nombre del producto:</label>
                
                <?php echo '<input type="nombre" name="nombre" id="nombre" placeholder="Nombre" required value="'.$producto->getNombre().'">';?>
            </p>
            <p>
                <label for="precio">Precio del producto:</label>
                <!-- Añadimos step para poder añadir decimales a la cifra -->
                
                <?php echo '<input type="number" name="precio" id="precio" step="0.01" placeholder="Precio" value="'.$producto->getPrecio().'"required>';?>
            </p>
            <p>
                <label for="unidades">Unidades disponibles:</label>
                <?php echo '<input type="number" name="unidades" id="unidades" placeholder="Unidades" value="'.$producto->getUnidades().'" required>'; ?>
            </p>
            <p>
                <label for="descripcion">Descripción del producto:</label>
                <?php echo '<textarea name="descripcion" cols="60" rows="6">'.$producto->getDescripcion().'</textarea>'; ?>
            </p>
            <p>
                <label for="tienda">Tienda en la que se venderá el producto</label>
                <select name="tienda" placeholder="" required>
                    <option value="" disabled hidden>--Escoge una de tus tiendas--</option>
                    <?php
                        echo '<option value="'.$producto->getTienda().'"selected>'.$producto->getNombreTienda().'</option>';  
                    ?>
                </select>
            </p>
            <input type="submit" name="registrar" id="registrar" value="Actualizar Producto">
        </form>
    </body>
</html>