<?php

    namespace App\Models\Traits;

    require_once __DIR__ .'/../../core/Database.php';

    // Le damos un alias a Database
    use App\Core\Database as Database;

    trait getUserName{

        /**
         * Recoger nombre de usuario
         * 
         * Recoge el nombre de un usuario usando una consulta preparada y su id (en EmptyModel porque lo usan varias clases).
         * 
         * @param int $id Id del usuario.
         * 
         * @return array $nombre El nombre del usuario.
         */
        public function getUserName($id) {
            try{
                $db = Database::getInstance()->getConnection();

                $params = [];
                $sql = "SELECT Nombre FROM Usuario WHERE Id_Usuario=$id;";

                $stmt = $db->prepare($sql);
                $stmt->execute($params);
                $nombre = $stmt->fetch();       
                    
                return $nombre;
            }catch(Exception $error){
                Security::generateErrors("consulta");
            }
        }
    }