<!-- /**
 * Cuerpo principal/main
 * 
*/ -->
<!DOCTYPE html>
<html lang="es">
    <?php require_once __DIR__ .'/./head.php';?>
    <body>
        <div class="titulo"><a href="index.php?route=core/index"><i class="fa-solid fa-crown"></i><h1>Gestor Rei</h1></a></div>
        <div class="contenido">
            <?php if($_COOKIE["session"]==1){?>
                <div class="barraLateral">
                    <a class="botonEnlace" href="index.php?route=task/index"><i class="fa-solid fa-file"></i></a>
                    <?php if($_SESSION["loginData"]["Privilegios"]==1 || $_SESSION["loginData"]["Privilegios"]==2){?>
                        <a class="botonEnlace" href="index.php?route=item/index"><i class="fa-solid fa-boxes-stacked"></i></a>
                    <?php };?>
                    <?php if($_SESSION["loginData"]["Privilegios"]==1){?>
                        <a class="botonEnlace" href="index.php?route=user/index"><i class="fa-solid fa-users"></i></a>
                        <a class="botonEnlace" href="index.php?route=user/manage"><i class="fa-solid fa-user-plus"></i></a>
                    <?php };?>
                    <a class="botonEnlace" href="index.php?route=core/logoff"><i class="fa-solid fa-door-open"></i></a>
                </div>
            <?php };?>
            <main>
                <?php echo $content; // Mostrar el contenido dinámico ?>
            </main>
        </div>

    </body>
    <?php require_once __DIR__ .'/./footer.php';?>
</html>    