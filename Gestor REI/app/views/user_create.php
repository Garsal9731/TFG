<?php
ob_start();
?>

<h2>Crear Usuario</h2>
<form  method="POST">
    <label for="name">Nombre:</label>
    <input type="text" name="name" required>
    <input type="submit" value="Crear Usuario">
</form>

<?php
$content = ob_get_clean();
require 'views/layouts/main.php';
?>