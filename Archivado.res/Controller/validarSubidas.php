<?php

require '../Model/usuario.php';

// ! SUBIR LOS ARCHIVOS Y ADAPTARLOS A EL ESQUEMA DE LA BASE DE DATOS
echo "<pre>";
    var_dump($_FILES["archivos"]);
echo "</pre>";
echo "<br>";
echo "-------------------------------<br>";
foreach($_FILES["archivos"] as $archivo){
    echo "<pre>";
        var_dump($archivo);
    echo "</pre>";
    echo "<br>";
}

// Especificamos la ruta donde se guardarán los archivos
$directorioArchivos = "../View/assets/";

// // Guardamos el nombre del archivo en una variable
// $nombreArchivo = basename($_FILES["file"]["name"]);

// // Recogemos el tipo de archivo para comprobarlo más tarde
// $extensionArchivo = pathinfo($nombreArchivo,PATHINFO_EXTENSION);

// // Creamos una ruta usando la ruta base y el nombre de archivo
// $rutaArchivo = $directorioArchivos.$idProducto.".$extensionArchivo";

// // Comprobamos que se ha enviado el formulario y que el input del archivo no está vacío
// if(isset($_POST["registrar"]) && !empty($_FILES["file"]["name"])){

//     // Creamos un array con los tipos de archivos
//     $tiposArchivos = array("jpg","png","jpeg");

//     // Comprobamos si el tipo de archivo está en el array de tipos
//     if(in_array($extensionArchivo,$tiposArchivos)){
//         if(move_uploaded_file($_FILES["file"]["tmp_name"],$rutaArchivo)){
//             // $producto = new Producto($idProducto,$_POST["tienda"],$_POST["nombre"],$_POST["descripcion"],$rutaArchivo,$_POST["unidades"],$_POST["precio"]);
//             $producto = new Producto($idProducto,$_POST["tienda"],$_POST["nombre"],$_POST["descripcion"],$rutaArchivo,$_POST["unidades"],$_POST["precio"]);
            
//             $producto->registrar();

//         }
//     }
// }

// header('Location: index.php');
// die();