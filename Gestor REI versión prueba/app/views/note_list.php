<?php
ob_start();
?>

<h2>Lista de Notas</h2>
<a href="index.php?route=note/create">Crear Nota</a>
<ul>
    <?php foreach ($notes as $note): ?>
        <li>
            <?php echo $note['content']; ?> (Usuario ID: <?php echo $note['user_id']; ?>) - Calificación: <?php echo $note['nota']; ?>
            <a href="index.php?route=note/edit&id=<?php echo $note['id']; ?>">Editar</a>
            <a href="index.php?route=note/delete&id=<?php echo $note['id']; ?>">Eliminar</a>
        </li>
    <?php endforeach; ?>
</ul>

<?php
$content = ob_get_clean();
require 'views/layouts/main.php';
?>