<?php    
    /**
     * Vista inicial general
     * 
     */
    ob_start();
?>

<div class="contenedor">
    <h2>Bienvenido <?php echo ucfirst($_SESSION["loginData"]["Nombre"]);?></h2>
    <div class="cuerpoInicial">
        <?php if($_SESSION["loginData"]["Privilegios"]!==1 && $_SESSION["loginData"]["Privilegios"]!==4){?>
            <p>¡Bienvenido al Gestor Rei!</p>
            <p>En el Gestor Rei puedes llevar un recuento de tus tareas/incidencias pendientes, objetos en tu trabajo/asociación/institución, y asignar tareas a otros empleados/técnicos.</p>
            <div class="botones">
                <div class="boton">            
                    <p>Tareas</p>
                    <a class="botonEnlace" href="index.php?route=task/index"><i class="fa-solid fa-file"></i></a>
                </div>
                <?php if($_SESSION["loginData"]["Privilegios"]==2){?>
                <div class="boton">            
                    <p>Objetos</p>
                    <a class="botonEnlace" href="index.php?route=item/index"><i class="fa-solid fa-boxes-stacked"></i></a>
                </div>
                <?php };?>
                <div class="boton">                
                    <p>Cerrar Sesión</p>
                    <a class="botonEnlace" href="index.php?route=core/logoff"><i class="fa-solid fa-door-open"></i></a>
                </div>
            </div>
        <?php }elseif($_SESSION["loginData"]["Privilegios"]==1){ ?>
            <div class="botones">
                <div class="boton">            
                    <p>Tareas</p>
                    <a class="botonEnlace" href="index.php?route=task/index"><i class="fa-solid fa-file"></i></a>
                </div>
                <div class="boton">            
                    <p>Objetos</p>
                    <a class="botonEnlace" href="index.php?route=item/index"><i class="fa-solid fa-boxes-stacked"></i></a>
                </div>
                <div class="boton">
                    <p>Usuarios</p>
                    <a class="botonEnlace" href="index.php?route=user/index"><i class="fa-solid fa-users"></i></a>
                </div>                
                <div class="boton">                
                    <p>Permisos</p>
                    <a class="botonEnlace" href="index.php?route=user/manage"><i class="fa-solid fa-user-plus"></i></a>
                </div>
                <div class="boton">                
                    <p>Cerrar Sesión</p>
                    <a class="botonEnlace" href="index.php?route=core/logoff"><i class="fa-solid fa-door-open"></i></a>
                </div>
            </div>
        <?php }else{ ?>
            <div class="botones">
                <div class="boton">            
                    <p>Tareas</p>
                    <a class="botonEnlace" href="index.php?route=task/index"><i class="fa-solid fa-file"></i></a>
                </div>
                <div class="boton">            
                    <p>Objetos</p>
                    <a class="botonEnlace" href="index.php?route=item/index"><i class="fa-solid fa-boxes-stacked"></i></a>
                </div>
                <div class="boton">
                    <p>Usuarios</p>
                    <a class="botonEnlace" href="index.php?route=user/index"><i class="fa-solid fa-users"></i></a>
                </div>                
                <div class="boton">                
                    <p>Permisos</p>
                    <a class="botonEnlace" href="index.php?route=user/manage"><i class="fa-solid fa-user-plus"></i></a>
                </div>
                <div class="boton">                
                    <p>Instituciones</p>
                    <a class="botonEnlace" href="index.php?route=inst/index"><i class="fa-solid fa-building"></i></a>
                </div>
                <div class="boton">                
                    <p>Cerrar Sesión</p>
                    <a class="botonEnlace" href="index.php?route=core/logoff"><i class="fa-solid fa-door-open"></i></a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";