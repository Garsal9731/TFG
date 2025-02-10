<?php

    require '../Model/contenido.php';

    session_start();

    $titulo = $_POST["nombre_post"];
    $tipo = $_POST["tipo_contenido"];
    $detalles = $_POST["detalles"];
    $autor_original = $_POST["autor_original"];
    $id_autor = $_SESSION["idusuario"];

    $autor = $_SESSION["idusuario"];

    if(isset($_COOKIE["idsArchivos"])){
        $archivos = $_COOKIE["idsArchivos"];
    }else{
        $archivos = "Error de archivos";
    }

    $fecha = date("Y-m-d");

    echo '<p>TITULO: '.$titulo.'</p>';
    echo '<p>TIPO: '.$tipo.'</p>';
    echo '<p>DETALLES: '.$detalles.'</p>';
    echo '<p>AUTOR ORIGINAL: '.$autor_original.'</p>';
    echo '<p>ID AUTOR: '.$id_autor.'</p>';
    echo '<p>AUTOR: '.$autor.'</p>';
    echo '<p>ARCHIVOS: '.$archivos.'</p>';
    echo '<p>FECHA: '.$fecha.'</p>';


    $contenido = new Contenido("0",$titulo,$tipo,$autor,$autor_original,$detalles,$archivos,$id_autor,$fecha);
    
    setcookie("idsArchivos","",-1, "/");

    $contenido->registrarContenido();

