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
        <?php 
            if($_SESSION["loginData"]["Privilegios"]!==1 && $_SESSION["loginData"]["Privilegios"]!==4){
                // Cuerpo Usuarios y técnicos
                require_once __DIR__ .'/./layouts/bodies/body_user.php';
            }elseif($_SESSION["loginData"]["Privilegios"]==1){
                // Cuerpo Admins
                require_once __DIR__ .'/./layouts/bodies/body_admin.php';
            }else{
                // Cuerpo Owner
                require_once __DIR__ .'/./layouts/bodies/body_owner.php';
            } 
        ?>
    </div>
</div>
<?php
    $content = ob_get_clean();
    include "layouts/main.php";