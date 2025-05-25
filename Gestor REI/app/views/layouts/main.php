<!-- /**
 * Cuerpo principal/main
 * 
*/ -->
<!DOCTYPE html>
<html lang="es">
    <?php require_once __DIR__ .'/./head.php';?>
    <body>
        <div class="titulo">
            <a href="index.php?route=landing">
                <i class="fa-solid fa-crown"></i>
                <h1>Gestor Rei</h1>
            </a>
            <div class="contenedor_icono_burger icono_barras">
                <span class="primerabarra"></span>
                <span class="segundabarra"></span>
                <span class="tercerabarra"></span>
            </div>
        </div>
        <div class="contenido">
            <?php if($_SESSION["loginData"]!==null && count($_SESSION["loginData"])>2){?>
                <?php if($_SESSION["loginData"]["Privilegios"]==1 || $_SESSION["loginData"]["Privilegios"]==4){?>
                    <div id="barraLateral" class="barraLateral admin">
                <?php }else{ ?>
                    <div id="barraLateral" class="barraLateral">
                <?php }; ?>
                    <p>Tareas</p>
                    <a class="botonEnlace" href="index.php?route=task/index"><i class="fa-solid fa-file"></i></a>

                    <!-- Botones para técnicos y admins -->
                    <?php if($_SESSION["loginData"]["Privilegios"]==1 || $_SESSION["loginData"]["Privilegios"]==2){?>
                        <p>Objetos</p>
                        <a class="botonEnlace" href="index.php?route=item/index"><i class="fa-solid fa-boxes-stacked"></i></a>
                    <?php };?>

                    <!-- Botones Admin -->
                    <?php if($_SESSION["loginData"]["Privilegios"]==1 || $_SESSION["loginData"]["Privilegios"]==4){?>
                        <p>Usuarios</p>
                        <a class="botonEnlace" href="index.php?route=user/index"><i class="fa-solid fa-users"></i></a>
                        <p>Permisos</p>
                        <a class="botonEnlace" href="index.php?route=user/manage"><i class="fa-solid fa-user-plus"></i></a>
                    <?php };?>
                    <p>Cerrar Sesión</p>
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