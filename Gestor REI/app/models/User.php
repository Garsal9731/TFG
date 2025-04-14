<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Core\EmptyModel as EmptyModel;
    use \PDO as PDO;
    
    class User extends EmptyModel {

        // Constructor
        /**
         * @param VOID NULL
         * 
         * Extiende el constructor de EmptyModel usando la tabla de usuarios como referencia
         */
        public function __construct() {
            parent::__construct('Usuario');
        }

        // Recoger Institución
        /**
         * @param $id int
         * 
         * Recoge la id de la institución en la que trabaja el usuario usando una consulta preparada
         */
        public function getUserInst($id) {
            $sql = "SELECT * FROM Institución WHERE Id_Institución LIKE (SELECT Institución_Id_Institución FROM Trabajadores_Institución WHERE Usuario_Id_Usuario LIKE $id);";
            $inst = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $inst;
        }

        // Recoger datos por correo
        /**
         * @param $mail string
         * 
         * Recoge el correo y la contraseña del usuario usando el correo como referencia
         */
        public function getByMail($mail){
            $sql = 'SELECT * FROM Usuario WHERE Correo LIKE "'.$mail.'";';
            $data = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $data;
        }
    }
