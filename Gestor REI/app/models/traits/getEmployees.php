<?php

    namespace App\Models\Traits;

    require_once __DIR__ .'/../../core/Database.php';

    // Le damos un alias a Database
    use App\Core\Database as Database;

    trait getEmployees{

        /**
         * Recoger empleados
         * 
         * Recogemos los usuarios que son empleados del Jefe pasado
         * 
         * @param int $idJefe Id del jefe de los empleados que buscamos.
         * 
         * @return array $employees Array con los empleados cuyo jefe es el indicado.
         */
        public function getEmployees($idJefe){
            try{
                $db = Database::getInstance()->getConnection();

                $sql = "SELECT * FROM Usuario WHERE Id_Usuario IN (SELECT Id_Usuario FROM Jefes WHERE Id_Jefe=$idJefe);";

                $stmt = $db->prepare($sql);
                $stmt->execute($params);
                $employees = $stmt->fetchAll();

                return $employees;
            }catch(Exception $error){
                Security::generateErrors("consulta");
            }
        }
    }