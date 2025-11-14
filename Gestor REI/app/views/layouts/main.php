<!-- /**
 * Cuerpo principal/main
 * Revisamor el GET para saber si se encuentra en la página de inicio, ya que esta es completamente diferente
*/ -->
<!DOCTYPE html>
<html lang="es">
    <?php require_once __DIR__ .'/./head.php';?>
    <body>
        <?php if (count($_GET)==0){?>
            <div class="tituloInicio"></div>
            <div class="contenidoInicio">
            <main>
                <?php echo $content; // Mostrar el contenido dinámico ?>
            </main>
        </div>
        <?php }else{?>
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
                    <a class="botonEnlace" href="index.php?route=task/index">Tareas <i class="fa-solid fa-file"></i></a>

                    <!-- Botones para técnicos y admins -->
                    <?php if($_SESSION["loginData"]["Privilegios"]==1 || $_SESSION["loginData"]["Privilegios"]==2){?>
                        <a class="botonEnlace" href="index.php?route=item/index">Objetos <i class="fa-solid fa-boxes-stacked"></i></a>
                    <?php };?>

                    <!-- Botones Admin -->
                    <?php if($_SESSION["loginData"]["Privilegios"]==1 || $_SESSION["loginData"]["Privilegios"]==4){?>

                        <a class="botonEnlace" href="index.php?route=user/index">Usuarios <i class="fa-solid fa-users"></i></a>
                        <a class="botonEnlace" href="index.php?route=user/manage">Permisos <i class="fa-solid fa-user-plus"></i></a>
                    <?php };?>

                    <?php if($_SESSION["loginData"]["Privilegios"]==4){?>
                        <a class="botonEnlace" href="index.php?route=inst/index">Insituciones<i class="fa-solid fa-building"></i></a>
                    <?php };?>
                    <a class="botonEnlace" href="index.php?route=core/logoff">Cerrar Sesión <i class="fa-solid fa-door-open"></i></a>
                </div>
            <?php };?>
            <main>
                <?php echo $content; // Mostrar el contenido dinámico ?>
            </main>
        </div>
        <?php };?>
        

    </body>
</html>    