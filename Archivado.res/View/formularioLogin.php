<!DOCTYPE html>
<html lang="es">
  <?php 
    $nombrePagina="Login";
    include 'head.php';
  ?>
  <body class="cuerpo_registro">
    <div class="formulario_login">
      <form action="../Controller/iniciarSesion.php" method="POST" autocomplete="off">
        <p>  
          <label for="nombre">Nombre Usuario:</label>
          <input type="text" name="nombre" required>
        </p>
        <p>
          <label for="contra">Contraseña:</label>
          <input type="password" name="contra" required>
        </p>
        <p>
          <input type="submit" name="registrar" value="Registrar">
        </p>
      </form>
      <p>¿No tienes una cuenta?. Haz click <a href="registro.php">aqui</a>.</p>
    </div>
  </body>
</html>