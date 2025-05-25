<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Core\EmptyModel as EmptyModel;

    class Inst extends EmptyModel {
    
        // Constructor
        /**
         * @param VOID NULL
         * 
         * Extiende el constructor de EmptyModel usando la tabla de institución como referencia
         */
        public function __construct() {
            parent::__construct('Institución');
        }

        // Recoger datos de Instituciones para el ajax
        /**
         * @param $peticion string
         * 
         * Busca la peticion en la bd usando una consulta preparada
         */
        public function ajaxInstitucion($peticion){
            $sql = 'SELECT * FROM Institución WHERE Nombre_Institución LIKE "'.$peticion.'%";';
            return $this->query($sql)->fetchAll();
        }
    }
