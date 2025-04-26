<?php

    namespace App\Models\Traits;

    require_once __DIR__ .'/../../core/Database.php';

    // Le damos un alias a Database
    use App\Core\Database as Database;

    trait getEmployees{
        // Recoger empleados
        /**
         * @param $idJefe int
         * 
         * Recogemos los usuarios que son empleados del Jefe pasado
         */
        public function getEmployees($idJefe){
            $db = Database::getInstance()->getConnection();

            $sql = "SELECT * FROM Usuario WHERE Id_Usuario IN (SELECT Id_Usuario FROM Jefes WHERE Id_Jefe=$idJefe);";

            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            $employees = $stmt->fetchAll();

            return $employees;
        }
    }