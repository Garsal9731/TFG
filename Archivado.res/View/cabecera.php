<header>
    <a href="../Controller/index.php"><h1>Archivado.res</h1></a>
    <div class="separador_header">
    <?php
        if(isset($privilegio)){

            // Si es admin
            if($privilegio==1){
                echo '<a href="../Controller/subir.php"><i class="fa-solid fa-upload"></i></a>';
                echo '<a href="../Controller/panelAdmin.php">Panel de Administrador</a>';
                echo '<a href="../Controller/cerrarSesion.php">Cerrar Sesión</a>';
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


            // Hacemos que se vea el panel de admin si los privilegios son los adecuados
            if($usuarioSesion->getPriv()==1){
                echo '<a href="../Controller/subir.php"><i class="fa-solid fa-upload"></i></a>';
                echo '<a href="../Controller/panelAdmin.php">Panel de Administrador</a>';
                echo '<a href="../Controller/cerrarSesion.php">Cerrar Sesión</a>';
            }else{
                echo '<a href="../Controller/subir.php"><i class="fa-solid fa-upload"></i></a>';
                echo '<a href="../Controller/cerrarSesion.php">Cerrar Sesión</a>';
            }
        }
    ?>
    </div>
</header>
<p class="barra_opciones">
    <a href="../Controller/index.php">Ver archivos</a>
    <a href="../Controller/misSubidas.php">Mis Archivos</a>
    <?php
        echo '<a href="../Controller/perfil.php?id='.$_SESSION["idusuario"].'">Mi Perfil</a>';
    ?>
</p>