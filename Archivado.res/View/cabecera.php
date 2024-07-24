<header>
    <a href="../Controller/index.php"><h1>Archivado.res</h1></a>
    <div class="separador_header">
    <?php
        // ! REVISAR LA ESTRUCTURA
            if(isset($privilegio)){

                // Si es admin
                if($privilegio==1){
                    echo '<a href="../Controller/panelAdmin.php">Panel de Administrador</a>';
                }else{
                    
                    echo '<a href="../Controller/subir.php"><i class="fa-solid fa-upload"></i></a>';

                    // Si el usuario es anonimo (privilegio 2) aparece el botón para iniciar sesión o registrarse
                    if($privilegio==2){
                        echo '<a href="../Controller/login.php">Iniciar Sesión/Registrarse</a>';
                    }else{
                        echo '<a href="../Controller/cerrarSesion.php">Cerrar Sesión</a>';
                    }
                }
            }else{

                echo '<a href="../Controller/subir.php"><i class="fa-solid fa-upload"></i></a>';

                // Hacemos que se vea el panel de admin si los privilegios son los adecuados
                if($usuarioSesion->getPriv()==1){
                    echo '<a href="../Controller/panelAdmin.php">Panel de Administrador</a>';
                }else{
                    echo '<a href="../Controller/cerrarSesion.php">Cerrar Sesión</a>';
                }
            }
    ?>
    </div>
</header>
<p class="barra_opciones">
    <a href="../Controller/index.php">Ver archivos</a>
    <!-- <a href="../Controller/tiendas.php">Ver tiendas</a> -->
    <!-- <a href="../Controller/formularioProductos.php">Crear Producto</a> -->
    <!-- <a href="../Controller/formularioTiendas.php">Crear Tienda</a> -->
    <!-- <a href="../Controller/misproductos.php">Mis Productos</a> -->
    <!-- <a href="../Controller/mistiendas.php">Mis Tiendas</a> -->
    <a href="../Controller/misSubidas.php">Mis Subidas</a>
    <!-- <a href="../Controller/carrito.php">Ver Carrito</a> -->
</p>