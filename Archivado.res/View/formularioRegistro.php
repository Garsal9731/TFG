<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../View/estilos.css">
      <title>Registro</title>
  </head>
  <body class="cuerpo_registro">
    <div class="formulario_registro">
      <form action="../Controller/registrarUsuario.php" method="POST" autocomplete="off">
        <p>  
          <label for="nombre">Nombre Usuario:</label>
          <input type="text" name="nombre" required>
        </p>
        <p>
          <label for="contra">Contraseña:</label>
          <input type="password" name="contra" required>
        </p>
        <p>
          <label for="correo">Correo:</label>
          <input type="text" name="correo" required>
        </p>
        <p>
          <label for="privilegio">¿Es superusuario?</label>
          <input type="checkbox" name="privilegio">
        </p>
        <p>
          <input type="submit" name="registrar" value="Registrar">
        </p>
      </form>
      <p>¿Ya tienes una cuenta?. Haz click <a href="login.php">aqui</a>.</p>
    </div>
  </body>
</html>