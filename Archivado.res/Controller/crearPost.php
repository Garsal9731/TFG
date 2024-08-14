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

    // ! DISPARIDAD SI  NO HAY ARCHIVOS, LA ULTIMA ID SE VOLVERÁ 1 PERO SERA DISTINTA EN LA BASE DE DATOS
    if(isset($_COOKIE["idsArchivos"])){
        $archivos = json_decode($_COOKIE["idsArchivos"],true);
    }
    var_dump($archivos);

    foreach($archivos as $id){
        Archivo::getArchivoById($id);
    }