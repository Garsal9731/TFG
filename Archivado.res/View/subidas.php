<!DOCTYPE html>
<html lang="es">
    <?php 
        $nombrePagina="Mis Subidas";
        include 'head.php';
    ?>
    <body>
        <?php include 'cabecera.php'; ?>
        <?php
            foreach($archivos as $archivo){
            
                // ! CREAR MISMA PAGINA PERO PARA POSTS Y PODER EDITARLOS
                echo '<article class="tarjeta_reserva">';
                    echo '<p>'.$archivo->getNombre().'</p>';
                    $extension = explode(".",$archivo->getNombre())[1];
                    echo $extension;

                    // ! REVISAR ESTRUCTURA
                    switch ($extension) {
                        // Media
                        case "jpg":
                            echo '<img width=200px height=200px src="'.$archivo->getRuta_archivo().'"></img>';
                            break;
                        case "png":
                            echo '<img width=200px height=200px src="'.$archivo->getRuta_archivo().'"></img>';
                            break;
                        case "jpeg":
                            echo '<img width=200px height=200px src="'.$archivo->getRuta_archivo().'"></img>';
                            break;
                        case "svg":
                            echo '<img width=200px height=200px src="'.$archivo->getRuta_archivo().'"></img>';
                            break;
                        // Programación
                        case "sh":
                            echo '<i class="fa-solid fa-terminal"></i>';
                            break;
                        case "bat":
                            echo '<i class="fa-solid fa-terminal"></i>';
                            break;
                        // Otros Archivos
                        case "zip":
                            echo '<i class="fa-solid fa-file-zipper"></i>';
                            break;
                        case "rar":
                            echo '<i class="fa-solid fa-file-zipper"></i>';
                            break;
                        case "mp3":
                            echo '<i class="fa-solid fa-music"></i>';
                            break;
                        case "wav":
                            echo '<i class="fa-solid fa-music"></i>';
                            break;
                        case "pdf":
                            echo '<i class="fa-solid fa-file-pdf"></i>';
                            break;
                        // Cualquier otro archivo
                        default:
                            echo '<i class="fa-solid fa-file"></i>';
                            break;
            
                    }
                    // ! Crear página de borrado usando la id y pensar como editar los post con el archivo a borrar, o si borrarlos
                    echo '<a href="../Controller/borrarArchivo.php?id='.$archivo->getId().'">Borrar Archivo</a>';
                echo '</article>';
            }
        ?>
    </body>
</html>