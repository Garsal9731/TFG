<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Core\EmptyModel as EmptyModel;

    class Inst extends EmptyModel {
    
        /**
         * Constructor Institución
         * 
         * Extiende el constructor de EmptyModel usando la tabla de institución como referencia.
         * 
         * @param void
         * 
         * @return void
         */
        public function __construct() {
            parent::__construct('Institución');
        }

        /**
         * Recoger datos de Instituciones para el ajax
         * 
         * Busca la peticion en la bd usando una consulta preparada.
         * 
         * @param string $peticion Petición que vamos a buscar en la base de datos.
         * 
         * @return array Array con los datos recogidos tras la busqueda.
         */
        public function ajaxInstitucion($peticion){
            $sql = 'SELECT * FROM Institución WHERE Nombre_Institución LIKE "'.$peticion.'%";';
            return $this->query($sql)->fetchAll();
        }
    }
