<?php

    // Definimos el namespace
    namespace App\Models;

    require_once __DIR__ .'/../core/EmptyModel.php';

    // Le damos un alias a EmptyModel
    use App\Core\EmptyModel as EmptyModel;
    use \PDO as PDO;
    
    class User extends EmptyModel {

        /**
         * Constructor
         * 
         * Extiende el constructor de EmptyModel usando la tabla de usuarios como referencia
         * 
         * @param void
         * 
         * @return void
         */
        public function __construct() {
            parent::__construct('Usuario');
        }

        /**
         * Recoger datos por correo
         * 
         * Recoge el correo y la contraseña del usuario usando el correo como referencia.
         * 
         * @param string $mail Correo que vamos a usar para buscar al usuario.
         * 
         * @return array Datos del usuario.
         */
        public function getByMail($mail){
            $sql = 'SELECT * FROM Usuario WHERE Correo = "'.$mail.'";';
            $data = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        /**
         * Recoger datos por correo para el ajax
         * 
         * Recoge el correo y la contraseña del usuario usando el correo como referencia.
         * 
         * @param string $mail Correo que vamos a buscar en la base de datos.
         * 
         * @return array Array con los datos de los usuarios.
         */
        public function ajaxMail($mail,$idInst){
            if($_SESSION["loginData"]["Privilegios"]==4){
                $sql = 'SELECT Id_Usuario,Nombre,Correo,Nombre_Privilegio FROM Usuario INNER JOIN Privilegios ON Usuario.Privilegios=Privilegios.id_Privilegios WHERE Correo LIKE "'.$mail.'%" ORDER BY Id_Usuario DESC;';
            }else{
                $sql = 'SELECT Id_Usuario,Nombre,Correo,Nombre_Privilegio FROM Usuario INNER JOIN Privilegios ON Usuario.Privilegios=Privilegios.id_Privilegios INNER JOIN Trabajadores_Institución ON Usuario.Id_Usuario=Usuario_Id_Usuario WHERE Correo LIKE "'.$mail.'%" AND Institución_Id_Institución='.$idInst.' ORDER BY Id_Usuario DESC;';
            }
            return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Registrar usuarios en Institución
         * 
         * Usamos la id del usuario y la id de la institución para registrar al usuario en la institución.
         * 
         * @param int $idUser Id del usuario que vamos a registrar en la institución.
         * @param int $idInst Id de la institución en la que vamos a registrar al usuario.
         * 
         * @return void
         */
        public function registerUserInst($idUser,$idInst){
            $sql = "INSERT INTO Trabajadores_Institución VALUES ($idUser,$idInst);";
            $this->query($sql);
        }

        /**
         * Registrar Empleados
         * 
         * Usamos la id del jefe y la del empleado para registrar la relación de Jefe-Empleado en la base de datos.
         * 
         * @param int $idJefe Id del jefe que manda sobre el empleado.
         * @param int $idEmpleado Id del empleado.
         * 
         * @return void
         */
        public function employeeRegister($idJefe,$idEmpleado){
            $sql = "INSERT INTO Jefes VALUES ($idJefe,$idEmpleado);";
            $this->query($sql);
        }

        /**
         * Revisar si correo existe
         * 
         * Mandamos una query para revisar si el correo existe en la base de datos.
         * 
         * @param string $correo Correo a buscar.
         * 
         * @return bool Booleano que indica si el correo existe o no.
         */
        public function checkMail($mail){
            $sql = "SELECT Correo FROM Usuario WHERE Correo='$mail';";
            $query = $this->query($sql)->fetch(PDO::FETCH_ASSOC);

            if($query==false){
                return false;
            }else{
                return true;
            }
        }

        /**
         * Revisar si el permiso ya se ha asignado anteriormente
         * 
         * Mandamos una query para revisar si el permiso de un usuario sobre otro ya se ha asignado anteriormente para evitar fallos y repetición.
         * 
         * @param int $idJefe Id del usuario Jefe.
         * @param int $empleado Id del usuario "Empleado" U "Subordinado".
         * 
         * @return bool Booleano que indica si la relación Jefe-Subordinado existe entre esos usuarios.
         */
        public function checkPermits($idJefe,$empleado){
            $sql = "SELECT * FROM Jefes WHERE Id_Jefe=".$idJefe." AND Id_Usuario=".$empleado.";";
            $query = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
            
            if($query==false){
                return false;
            }else{
                return true;
            }
        }

        /**
         * Recoger empleados y Jefes de los propios
         * 
         * Recoge los empleados y los jefes usando la institución a la que pertenecen usando una query en la base de datos.
         * 
         * @param int $idInst Id de la institución a la que pertenece el usuario.
         * @param string $peticion Nombre del jefe que vamos a usar para filtrar las busquedas.
         * 
         * @return array Relaciones de los Jefes indicados por $petición y el resto de usuarios, o de todos los jefes y usuarios de esa institución.
         */
        public function getBosses($idInst,$peticion){
            if($_SESSION["loginData"]["Privilegios"]==1){
                $sql = 'SELECT Jefes.Id_Jefe, Jefes.Id_Usuario, Jefe.Nombre AS "Jefe", Empleado.Nombre AS "Empleado" FROM Jefes INNER JOIN Usuario AS Jefe ON Jefe.Id_Usuario=Jefes.Id_Jefe INNER JOIN Usuario AS Empleado ON Empleado.Id_Usuario=Jefes.Id_Usuario INNER JOIN Trabajadores_Institución AS Inst ON Jefe.Id_Usuario=Inst.Usuario_Id_Usuario WHERE Inst.Institución_Id_Institución='.$idInst.' AND Jefe.Nombre LIKE "'.$peticion.'%";';
            }elseif($_SESSION["loginData"]["Privilegios"]==4){
                $sql = 'SELECT Jefes.Id_Jefe, Jefes.Id_Usuario, Jefe.Nombre AS "Jefe", Empleado.Nombre AS "Empleado" FROM Jefes INNER JOIN Usuario AS Jefe ON Jefe.Id_Usuario=Jefes.Id_Jefe INNER JOIN Usuario AS Empleado ON Empleado.Id_Usuario=Jefes.Id_Usuario;';
            }
            return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Borrar Permisos
         * 
         * Usando la id del jefe y el empleado borramos la relación entre ellos.
         * 
         * @param int $idJefe Id del Jefe.
         * @param int $idEmpleado Id del empleado.
         * 
         * @return void
         */
        public function deletePermits($idJefe,$idEmpleado){
            $sql = "DELETE FROM Jefes WHERE Id_Jefe=".$idJefe." AND Id_Usuario=".$idEmpleado.";";
            if($this->query($sql)){
                return true;
            }else{
                return false;
            }
        }
    }
