<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo User
    require_once __DIR__ . '/../models/User.php';

    use App\Models\User as User;

    class UserController {

        private $userModel;

        // Constructor
        /**
         * @param VOID NULL
         * 
         * El constructor crea un usuario nuevo usando el constructor del usuario
         */
        public function __construct() {
            $this->userModel = new User();
        }

        // Recoger Todo
        /**
         * @param VOID NULL
         * 
         * Llamamos al modelo usuario y recogemos todos los usuarios 
         */
        public function getAll(){
            $users = $this->userModel->getAll();
            return $users;
        }

        // Recoger Todo usando correo como referencia
        /**
         * @param $mail
         * 
         * Recogemos los datos del usuario usando el correo como referencia
         */
        public function getByMail($mail){
            $data = $this->userModel->getByMail($mail);
            return $data;
        }

        // Indice
        /**
         * @param VOID NULL
         * 
         * Usa el metodo de recoger todos los registros de la base de datos para recoger todos los usuarios y llamamos a la vista
         */ 
        public function index() {
            $users = $this->getAll();
            require __DIR__ . '/../views/user_list.php';
        }

        // Crear 
        /**
         * @param VOID NULL
         * 
         * Usamos el metodo crear del EmptyModel y recogemos los datos por POST
         */ 
        public function create() {

            // ! AÑADIR COMPROBACIÓN DE CORREO PARA VER SI YA EXISTE
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                // Ciframos la contraseña
                $cifrado = password_hash($_POST['contra'], PASSWORD_DEFAULT);

                // Cambiamos el tipo de dato de privilegio (por defecto se recoge como string)
                settype($_POST["privilegios"], "int");
                $this->userModel->create(['Nombre' => $_POST['nombre'],'Contraseña' => $cifrado,'Correo' => $_POST['correo'],'Privilegios' => $_POST["privilegios"]]);

                // Recogemos la última id de usuario registrada (el nuevo usuario)
                $lastId = $this->userModel->getLastId();

                // Rcogemos la id del usuario actual y la usamos para encontrar a que institución pertenece y después recogemos la id de la institución
                $idUser = $_SESSION["loginData"]["Id_Usuario"]; 
                $idInst = $this->userModel->getUserInst($idUser)["Id_Institución"];

                // Registramos al usuario en la misma institución (los admin de cada institución solo pueden registrar en su institución)
                $this->userModel->registerUserInst($lastId,$idInst);

                header('Location: index.php?route=user/index');
            } else {
                require __DIR__ . '/../views/user_create.php';
            }
        }

        // Editar
        /**
         * @param $id int
         * 
         * Usamos el metodo editar del EmptyModel, recogemos los datos por POST y le pasamos la id para actualizar el registro
         */
        // ! CAMBIAR PARA AÑADIR OTROS CAMPOS
        public function edit($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->userModel->update(['Nombre' => $_POST['nombre']], $id);
                header('Location: index.php?route=user/index');
            } else {
                $user = $this->userModel->getById($id);
                require __DIR__ . '/../views/user_edit.php';
            }
        }

        // Borrar
        /**
         * @param $id int
         * 
         * Usamos el metodo borrar del EmptyModel y borramos el registro usando la id
         */
        public function delete($id) {
            $this->userModel->delete($id);
            header('Location: index.php?route=user/index');
        }

        // Manejar usuarios
        /**
         * @param $idUser int
         * 
         * Usamos la id del usuario para 
         */
        public function bossManage($idUser){

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                foreach($_POST["empleado"] as $empleado){
                    $this->userModel->employeeRegister($_POST["jefe"],$empleado);
                }
                header('Location: index.php?route=user/index');
            }else{
                $instInfo = $this->userModel->getUserInst($idUser);
                $idInst = $instInfo["Id_Institución"];
                $instName = $instInfo["Nombre_Institución"];
                $users = $this->userModel->getAllByInst($idInst);
                require __DIR__ . '/../views/user_manage.php';
            }
        }

        public function getEmployees($idJefe){
            $employees = $this->userModel->getEmployees($idJefe);
            return $employees;
        }
    }
