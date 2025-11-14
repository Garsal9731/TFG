<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Core\EmptyModel as EmptyModel;

    class Item extends EmptyModel {
    
        /**
         * Constructor Objeto
         * 
         * Extiende el constructor de EmptyModel usando la tabla de objeto como referencia.
         * 
         * @param void
         * 
         * @return void
         */
        public function __construct() {
            parent::__construct('Objeto');
        }

        /**
         * Recoger datos de Objetos para el ajax
         * 
         * Busca la peticion en la base de datos usando una consulta preparada.
         * 
         * @param string $peticion Nombre del objeto que vamos a buscar.
         * @param int $idInst Id de la institución a la que pertenece el objeto.
         * 
         * @return array Array de los resultados de la busqueda.
         */
        public function ajaxObjetos($peticion,$idInst){
            if ($_SESSION["loginData"]["Privilegios"]==4) {
                $sql = 'SELECT Id_Objeto,Nombre,Estado FROM Objeto WHERE Nombre LIKE "'.$peticion.'%" ORDER BY Id_Objeto DESC;';
            }else{
                $sql = 'SELECT Id_Objeto,Nombre,Estado FROM Objeto WHERE Nombre LIKE "'.$peticion.'%" AND Institución_Id_Institución="'.$idInst.'" ORDER BY Id_Objeto DESC;';
            }
            return $this->query($sql)->fetchAll();
        }
    }
