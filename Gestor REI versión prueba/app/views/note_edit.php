<?php
ob_start();
?>

<h2>Editar Nota</h2>
<form method="POST">
    <textarea name="content" required><?php echo $note['content']; ?></textarea>
    <input type="number" name="user_id" value="<?php echo $note['user_id']; ?>" required />
    <input type="number" name="nota" value="<?php echo $note['nota']; ?>" min="1" max="10" required /> <!-- Campo 'nota' -->
    <button type="submit">Guardar</button>
</form>

<?php
$content = ob_get_clean();
require 'views/layouts/main.php';
?>