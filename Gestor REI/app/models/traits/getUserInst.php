<?php

    namespace App\Models\Traits;

    require_once __DIR__ .'/../../core/Database.php';

    // Le damos un alias a Database
    use App\Core\Database as Database;

    trait getUserInst{

        /**
         * Recoger Institución del usuario actual
         * 
         * Recoge la id de la institución en la que trabaja el usuario usando una consulta preparada (en EmptyModel porque lo usan varias clases).
         * 
         * @param int $id Id del usuario del que buscar la institución.
         * 
         * @return array $inst Array con los datos de la institución a la que pertenece el usuario. 
         */
        public function getUserInst($id) {
            try{
                $db = Database::getInstance()->getConnection();

                $params = [];
                $sql = "SELECT * FROM Institución WHERE Id_Institución = (SELECT Institución_Id_Institución FROM Trabajadores_Institución WHERE Usuario_Id_Usuario = $id);";

                $stmt = $db->prepare($sql);
                $stmt->execute($params);
                $inst = $stmt->fetch();       
                    
                return $inst;
            }catch(Exception $error){
                Security::generateErrors("consulta");
            }
        }
    }