<?php
ob_start();
?>

<!-- create_note.php -->
<h2>Crear Nota</h2>
<form  method="POST">
    <div>
        <label for="content">Contenido:</label>
        <textarea name="content" required></textarea>
    </div>
    <div>
        <label for="nota">Nota (1-10):</label>
        <input type="number" name="nota" min="1" max="10" required>
    </div>
    <div>
        <label for="user_id">Selecciona un Usuario:</label>
        <select name="user_id" required>
            <?php
            // Obtener los usuarios registrados para el formulario
            require_once 'models/User.php';
            $userModel = new User();
            $users = $userModel->getAll(); // Obtener todos los usuarios

            // Mostrar los usuarios en el select
            foreach ($users as $user) {
                echo "<option value='" . $user['id'] . "'>" . $user['name'] . "</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <input type="submit" value="Crear Nota">
    </div>
</form>


<?php
$content = ob_get_clean();
require 'views/layouts/main.php';
?>