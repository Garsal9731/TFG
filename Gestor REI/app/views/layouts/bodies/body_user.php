<p>¡Bienvenido al Gestor Rei!</p>
<p>En el Gestor Rei puedes llevar un recuento de tus tareas/incidencias pendientes, objetos en tu trabajo/asociación/institución, y asignar tareas a otros empleados/técnicos.</p>
<div class="botones">
    <a class="botonEnlace" href="index.php?route=task/index">
        <div class="boton">            
            <p>Tareas</p>
            <i class="fa-solid fa-file"></i>
        </div>
    </a>
    <?php if($_SESSION["loginData"]["Privilegios"]==2){?>
        <a class="botonEnlace" href="index.php?route=item/index">
            <div class="boton">            
                <p>Objetos</p>
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
        </a>
    <?php };?>
    <a class="botonEnlace" href="index.php?route=core/logoff">
        <div class="boton">                
            <p>Cerrar Sesión</p>
            <i class="fa-solid fa-door-open"></i>
        </div>
    </a>
</div>