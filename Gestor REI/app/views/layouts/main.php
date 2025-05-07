<!-- /**
 * Cuerpo principal/main
 * 
*/ -->
<!DOCTYPE html>
<html lang="es">
    <?php require_once __DIR__ .'/./head.php';?>
    <body>
        <div class="titulo"><h1><a href="index.php?route=core/index">Gestor Rei</a></h1></div>
        <div class="contenido">
            <div class="barraLateral"></div>
            <main>
                <?php echo $content; // Mostrar el contenido dinámico ?>
            </main>
        </div>

    </body>
    <?php // require_once __DIR__ .'/./footer.php';?>
</html>    