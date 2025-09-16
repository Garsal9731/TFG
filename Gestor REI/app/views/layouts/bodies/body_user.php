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