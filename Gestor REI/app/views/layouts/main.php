<!-- /**
 * Cuerpo principal/main
 * 
*/ -->
<!DOCTYPE html>
<html lang="es">
    <?php require_once __DIR__ .'/./head.php';?>
    <body>
        <h1><a href="index.php?route=core/index">Gestor Rei</a></h1>
        <div>
            <?php echo $content; // Mostrar el contenido dinámico ?>
        </div>
    </body>
    <?php require_once __DIR__ .'/./footer.php';?>
</html>    