<?php

    // ! EJEMPLO DE CONSEGUIR MINIATURA
    // $image = exif_thumbnail('/path/to/image.jpg', $width, $height, $type);

    // if ($image!==false) {
    //     header('Content-type: ' .image_type_to_mime_type($type));
    //     echo $image;
    //     exit;
    // } else {
    //     // no thumbnail available, handle the error here
    //     echo 'No thumbnail available';
    // }

    require '../Model/contenido.php';

    if(isset($_COOKIE["idsArchivos"])){
        $archivos = json_decode($_COOKIE["idsArchivos"],true);
    }

    $arrayArchivos = [];
    foreach($archivos as $id){
        $archivo = Archivo::getArchivoById($id);
        var_dump($archivo);
        array_push($arrayArchivos,$archivo);
    }

    // ! AÑADIR FORMULARIO EN VISTAS Y USAR ARRAY DE OBJETOS PARA RECOGER DATOS
    var_dump($arrayArchivos);