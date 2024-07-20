<?php
    // ! NO CAMBIADO
    require '../Model/producto.php';
    
    session_start();

    $idProducto = $_SESSION["productoEditar"];

    $producto = Producto::getProductoById($idProducto);

    // Especificamos la ruta donde se guardarán los archivos
    $directorioArchivos = "../View/img/";

    // Guardamos el nombre del archivo en una variable
    $nombreArchivo = basename($_FILES["file"]["name"]);

    // Recogemos el tipo de archivo para comprobarlo más tarde
    $extensionArchivo = pathinfo($nombreArchivo,PATHINFO_EXTENSION);

    // Creamos una ruta usando la ruta base y el nombre de archivo
    $rutaArchivo = $directorioArchivos.$idProducto.".$extensionArchivo";
    
    // Si la foto no está vacía
    if($extensionArchivo!==''){
        
        // Comprobamos que se ha enviado el formulario y que el input del archivo no está vacío
        if(isset($_POST["registrar"]) && !empty($_FILES["file"]["name"])){

            // Creamos un array con los tipos de archivos
            $tiposArchivos = array("jpg","png","jpeg");

            // Comprobamos si el tipo de archivo está en el array de tipos
            if(in_array($extensionArchivo,$tiposArchivos)){

                // Borramos la foto
                unlink($producto->getFoto());

                // Guardamos la nueva y guardamos la ruta
                move_uploaded_file($_FILES["file"]["tmp_name"],$rutaArchivo);
                $rutaFoto = $rutaArchivo;
            }
        }
    }else{
        $rutaFoto = $producto->getFoto();
    }

    $productoEditado = new Producto($idProducto,$_POST["tienda"],$_POST["nombre"],$_POST["descripcion"],$rutaFoto,$_POST["unidades"],$_POST["precio"]);

    $productoEditado->actualizar();

    unset($_SESSION["productoEditar"]);

    header('Location: index.php');
    die();