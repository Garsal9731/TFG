<?php

    include '../Model/archivo.php';

    session_start();

    $id = $_GET["id"];
    $archivo = Archivo::getArchivoById($id);

    if($_SESSION["idusuario"]==$archivo->getUsuario()){
        Archivo::borrarPorId($id,$archivo->getRuta_archivo());
    }else{
        header('Location: index.php');
        die();
    }

    header('Location: index.php');
    die();