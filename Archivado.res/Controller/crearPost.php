<?php

    session_start();

    // Comprobamos que la session está abierta, de no estarlo se envia al registro
    if(!isset($_SESSION["usuario"])){
        $privilegio = 2;
    }else{
        $usuarioSesion = unserialize($_SESSION["usuario"]);
        $privilegio = $_SESSION["privilegio"];
    }

    function crearIcono($extension){
        switch ($extension) {
            // Programación
            case ".sh" || ".bat":
                echo '<i class="fa-solid fa-terminal"></i>';
                break;
            // Media
            case ".jpg" || ".png" || ".jpeg" || ".svg":
                echo '<i class="fa-solid fa-image"></i>';
                break;
            // Otros Archivos
            case ".zip" || ".rar":
                echo '<i class="fa-solid fa-file-zipper"></i>';
                break;
            case ".mp3" || ".wav":
                echo '<i class="fa-solid fa-music"></i>';
                break;
            case ".pdf":
                echo '<i class="fa-solid fa-file-pdf"></i>';
                break;
            // Cualquier otro archivo
            default:
                echo '<i class="fa-solid fa-file"></i>';
                break;

        }
    }

    require '../Model/contenido.php';

    if(isset($_COOKIE["idsArchivos"])){
        $archivos = json_decode($_COOKIE["idsArchivos"]);
    }

    var_dump($archivos);

    $arrayArchivos = [];
    foreach($archivos as $id){
        $archivo = Archivo::getArchivoById($id);
        var_dump($archivo);
        array_push($arrayArchivos,$archivo);
        $ruta = $archivo->getRuta_archivo();
        $formato = $archivo->getFormato();

        $formatosImagenes = array(".png",".jpg",".jpeg",".svg");
        if(in_array($formato,$formatosImagenes)){
            echo '<img src="'.$ruta.'" width="500" height="500"></img>';
            echo "<p>".$archivo->getNombre()."</p>";
        }else{
            // $image = exif_thumbnail($ruta, $width, $height, $type);
            $image = exif_thumbnail($ruta);

            if ($image!==false) {
                header('Content-type: ' .image_type_to_mime_type($type));
                echo $image;
                exit;
            } else {
                crearIcono($formato);
            }
        }
    }

    include '../View/formularioPost.php';