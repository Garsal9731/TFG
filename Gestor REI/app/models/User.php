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

        // Recoger datos por correo
        /**
         * @param $mail string
         * 
         * Recoge el correo y la contraseña del usuario usando el correo como referencia
         */
        public function getByMail($mail){
            $sql = 'SELECT * FROM Usuario WHERE Correo = "'.$mail.'";';
            $data = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        // Registrar usuarios en Institución
        /**
         * @param $idUser
         * @param $idInst
         * 
         * Usamos la id del usuario y la id de la institución para registrar al usuario en la institución
         */
        public function registerUserInst($idUser,$idInst){
            $sql = "INSERT INTO Trabajadores_Institución VALUES ($idUser,$idInst);";
            $this->query($sql);
        }

        // Recoger usuarios de Institución
        /**
         * @param $idInst
         * 
         * Usamos la id de la institución para recoger a todos los usuarios que trabajan en ella
         */
        public function getAllByInst($idInst){
            $sql = "SELECT * FROM Usuario WHERE Id_Usuario IN (SELECT Usuario_Id_Usuario FROM Trabajadores_Institución WHERE Institución_Id_Institución=$idInst);";
            $users = $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        }

        // Registrar Empleados
        /**
         * @param $idJefe
         * @param $idEmpleado
         * 
         * Usamos la id del jefe y la del empleado para registrar la relación de Jefe-Empleado en la BD
         */
        public function employeeRegister($idJefe,$idEmpleado){
            $sql = "INSERT INTO Jefes VALUES ($idJefe,$idEmpleado);";
            $this->query($sql);
        }

        public function getEmployees($idJefe){
            $sql = "SELECT * FROM Usuario WHERE Id_Usuario IN (SELECT Id_Usuario FROM Jefes WHERE Id_Jefe=$idJefe);";
            $employees = $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            return $employees;
        }
    }
