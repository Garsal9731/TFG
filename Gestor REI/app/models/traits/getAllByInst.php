<?php

    namespace App\Models\Traits;

    require_once __DIR__ .'/../../core/Database.php';

    // Le damos un alias a Database
    use App\Core\Database as Database;

    trait getAllByInst{
        
        // Recoger usuarios de Institución
        /**
         * @param $idInst int
         * 
         * Usamos la id de la institución para recoger a todos los usuarios que trabajan en ella
         */
        public function getAllByInst($idInst){
            try{
                $db = Database::getInstance()->getConnection();

                if($_SESSION["loginData"]["Privilegios"]!==3){
                    $sql = "SELECT * FROM Usuario WHERE Id_Usuario IN (SELECT Usuario_Id_Usuario FROM Trabajadores_Institución WHERE Institución_Id_Institución=$idInst);";
                }else{
                    $sql = "SELECT * FROM Usuario WHERE Id_Usuario IN (SELECT Usuario_Id_Usuario FROM Trabajadores_Institución WHERE Institución_Id_Institución=$idInst) AND Privilegios !=3;";
                }

                $stmt = $db->prepare($sql);
                $stmt->execute($params);
                $users = $stmt->fetchAll();

                return $users;
            }catch(Exception $error){
                Security::generateErrors("consulta");
            }
        }
    }