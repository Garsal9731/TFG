<?php
  require '../Model/usuario.php';
  $usuarioBorrar = Usuario::getUsuarioById($_GET['id']);

  $usuarioBorrar->eliminar();
  header("Location: index.php");
  die();