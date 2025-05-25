<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Core\EmptyModel as EmptyModel;

    class Item extends EmptyModel {
    
        // Constructor
        /**
         * @param VOID NULL
         * 
         * Extiende el constructor de EmptyModel usando la tabla de objeto como referencia
         */
        public function __construct() {
            parent::__construct('Objeto');
        }

        // Recoger datos de Objetos para el ajax
        /**
         * @param $peticion string
         * 
         * Busca la peticion en la bd usando una consulta preparada
         */
        public function ajaxObjetos($peticion,$idInst){
            if ($_SESSION["loginData"]["Privilegios"]==4) {
                $sql = 'SELECT Id_Objeto,Nombre,Estado FROM Objeto WHERE Nombre LIKE "'.$peticion.'%";';
            }else{
                $sql = 'SELECT Id_Objeto,Nombre,Estado FROM Objeto WHERE Nombre LIKE "'.$peticion.'%" AND Institución_Id_Institución="'.$idInst.'";';
            }
            return $this->query($sql)->fetchAll();
        }
    }
