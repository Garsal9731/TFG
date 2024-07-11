<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../View/estilos.css">
    <title>Crear Tienda</title>
  </head>
  <body>
    <?php include 'cabecera.php';?>
    <?php echo '<form action="../Controller/registrarTienda.php?idusuario='.$usuarioSesion->getId().'" method="POST" autocomplete="off">'; ?>
      <h3>Nombre Tienda</h3>
      <input type="text" size="40" name="nombre">
      <br><h3>Descripción</h3>
      <textarea name="descripcion" cols="60" rows="6">
      </textarea><hr>
      <input type="submit" value="Registrar">
    </form>
  </body>
</html>