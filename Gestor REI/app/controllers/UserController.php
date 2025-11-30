<?php

    // Definimos el namespace de los controladores
    namespace App\Controllers;

    // Llamamos al archivo con el modelo User y traits
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../models/traits/getEmployees.php';
    require_once __DIR__ . '/../models/traits/getUserInst.php';
    require_once __DIR__ . '/../models/traits/getAllByInst.php';
    require_once __DIR__ . '/../core/security.php';

    use App\Models\User as User;
    use App\Models\Traits\getEmployees as getEmployees;
    use App\Models\Traits\getUserInst as getUserInst;
    use App\Models\Traits\getAllByInst as getAllByInst;
    use App\Core\Security as Security;

    class UserController {

        use getEmployees, getUserInst, getAllByInst;

        private $userModel;

        /**
         * Constructor Usuario
         * 
         * El constructor crea un usuario nuevo usando el constructor del usuario.
         *
         * @param void
         * 
         * @return void
         */
        public function __construct() {
            $this->userModel = new User();
        }

        /**
         * Recoger Todo
         * 
         * Llamamos al modelo usuario y recogemos todos los usuarios.
         * 
         * @param void
         * 
         * @return array $users Datos de todos los usuarios
         */
        public function getAll(){
            $users = $this->userModel->getAll();
            return $users;
        }

        /**
         * Recoger Usuario usando correo
         * 
         * Recogemos los datos del usuario usando el correo como referencia.
         * 
         * @param string $mail Correo del usuario.
         * 
         * @return array $data Datos del usuario.
         */
        public function getByMail($mail){
            $data = $this->userModel->getByMail($mail);
            return $data;
        }

        /**
         * Ajax del correo de los usuarios
         * 
         * Recogemos los datos del usuario usando el correo y la institución que pertenece como referencia podemos localizar al usuario.
         * 
         * @param string $mail Correo a buscar en la base de datos.
         * 
         * @return array $data Datos del usuario.
         */
        public function ajaxMail($mail){
            $data = $this->userModel->ajaxMail($mail,$this->getUserInst($_SESSION["loginData"]["Id_Usuario"])["Id_Institución"]);
            return $data;
        }

        /**
         * Indice Usuarios
         * 
         * Usa el metodo de recoger todos los registros de la base de datos para recoger todos los usuarios y llamamos a la vista.
         * 
         * @param void
         * 
         * @return void
         */ 
        public function index() {
            require __DIR__ . '/../views/user_list.php';
        }

        /**
         * Crear Usuario
         *
         * Recogemos los datos recogidos por POST y los usamos para dar de alta al usuario.
         * De no haber datos por POST llamamos a la vista con el formulario.
         * 
         * @param array $insts Array con las instituciones, no se usa en la propia función, pero si en la vista llamada.
         * 
         * @return void
         */ 
        public function create($insts) {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                if($this->userModel->checkMail($_POST["correo"])==false){

                    // Ciframos la contraseña
                    $cifrado = password_hash($_POST['contra'], PASSWORD_DEFAULT);

                    // Cambiamos el tipo de dato de privilegio (por defecto se recoge como string)
                    settype($_POST["privilegios"], "int");
                    $this->userModel->create(['Nombre' => $_POST['nombre'],'Contraseña' => $cifrado,'Correo' => $_POST['correo'],'Privilegios' => $_POST["privilegios"]]);

                    // Recogemos la última id de usuario registrada (el nuevo usuario)
                    $lastId = $this->userModel->getLastId();

                    // Rcogemos la id del usuario actual y la usamos para encontrar a que institución pertenece y después recogemos la id de la institución
                    $idUser = $_SESSION["loginData"]["Id_Usuario"]; 

                    if($_POST["institucion"]!==null){
                        $idInst = $_POST["institucion"];
                    }else{
                        $idInst = $this->getUserInst($idUser)["Id_Institución"];
                    }

                    // Registramos al usuario en la misma institución (los admin de cada institución solo pueden registrar en su institución)
                    $this->userModel->registerUserInst($lastId,$idInst);

                    // Creamos una cookie para mandar el aviso de que se ha modificado la tarea
                    setcookie("status", "creado", time() + (86400 * 30), "/");

                    header('Location: index.php?route=user/index');
                }else{
                    Security::generateErrors("El correo ya existe");
                }
            } else {
                require __DIR__ . '/../views/user_create.php';
            }
        }

        /**
         * Editar Usuario
         * 
         * Usamos el metodo editar del EmptyModel, recogemos los datos por POST y le pasamos la id para actualizar el registro
         * De no haber datos por POST llamamos a la vista con el formulario.
         * 
         * @param int $id Id del usuario que queremos editar.
         * 
         * @return void
         */
        public function edit($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $contra = password_hash($_POST["contra"], PASSWORD_DEFAULT);

                $this->userModel->update(['Nombre' => $_POST['nombre'],'Contraseña' => $contra], $id);

                // Creamos una cookie para mandar el aviso de que se ha modificado la tarea
                setcookie("status", "mod", time() + (86400 * 30), "/");
                header('Location: index.php?route=user/index');
            } else {
                $user = $this->userModel->getById($id);
                require __DIR__ . '/../views/user_edit.php';
            }
        }

        /**
         * Borrar Usuario
         * 
         * Usamos el metodo borrar del EmptyModel y borramos el registro usando la id.
         * 
         * @param int $id Id del usuario que vamos a dar de baja.
         * 
         * @return void
         */
        public function delete($id) {
            $this->userModel->delete($id);

            // Creamos una cookie para mandar el aviso de que se dado de baja al usuario
            setcookie("status", "borrado", time() + (86400 * 30), "/");
            header('Location: index.php?route=user/index');
        }

        /**
         * Manejar permisos
         * 
         * Registramos los datos enviados por formulario, creando relación de Jefe-Empleado entre varios usuarios seleccionados.
         * De no haber datos por POST llamamos a la vista con el formulario.
         * 
         * @param int $idUser Usamos la id del usuario para registrar los permisos en la institución a la que pertenece.
         * 
         * @return void
         */
        public function bossManage($idUser){

            if($_SERVER['REQUEST_METHOD'] === 'POST'){

                foreach($_POST["empleados"] as $empleado){

                    if($_POST["jefe"][0]==$empleado){

                        // Creamos una cookie de fallo para avisar de que no se ha podido completar el proceso
                        setcookie("status", "fallo", time() + (86400 * 30), "/");
                    }else{
                        $rep = $this->userModel->checkPermits($_POST["jefe"][0],$empleado);
                        var_dump($rep);

                        // Si la repetición es falsa entonces pasamos a crear el registro de permisos
                        if($rep==false){
                            $this->userModel->employeeRegister($_POST["jefe"][0],$empleado);
                            
                            // Creamos una cookie para mandar el aviso de que se han asignado los permisos al usuario
                            setcookie("status", "asignado", time() + (86400 * 30), "/");
                        }else{
                            setcookie("status", "fallo", time() + (86400 * 30), "/");
                        }
                    }
                }
                
                header('Location: index.php?route=user/manage');
            }else{
                $instInfo = $this->getUserInst($idUser);
                $idInst = $instInfo["Id_Institución"];
                $instName = $instInfo["Nombre_Institución"];
                $users = $this->getAllByInst($idInst);
                require __DIR__ . '/../views/user_manage.php';
            }
        }

        /**
         * Manejar usuarios
         * 
         * Usamos la id del usuario para comprobar a que institución pertenece y llamamos al formulario para asignar los nuevos permisos.
         * 
         * @param int $idUser id del usuario que está entrando en la página.
         * 
         * @return void
         */
        public function permitsManage($idUser){
            $instInfo = $this->getUserInst($idUser);
            $idInst = $instInfo["Id_Institución"];
            require __DIR__ . '/../views/user_permits.php';
        }

        /**
         * Recoger Permisos
         * 
         * Usamos la id de la institución para buscar quien es jefe de quien.
         * 
         * @param int $idInst Id de la institución a la que pertenece el usuario.
         * @param string $peticion Hilo de texto enviado que se usa en la query del ajax para buscar en la base de datos.
         * 
         * @return array $permits array con los permisos de que usuario es jefe de quien.
         */
        public function getPermits($idInst,$peticion){
            $permits = $this->userModel->getBosses($idInst,$peticion);
            return $permits;
        }

        /**
         * Borrar permisos
         * 
         * Usamos la id del jefe y la del empleado para borrar sus permisos sobre el empleado.
         * 
         * @param int $idJefe Id del usuario que manda sobre otro usuario.
         * @param int $idEmpleado Id del usuario "subordinado".
         * 
         * @return void
         */
        public function deletePermits($idJefe,$idEmpleado){
            if($this->userModel->deletePermits($idJefe,$idEmpleado)){
                setcookie("status", "borrado", time() + (86400 * 30), "/");
            }else{
                setcookie("status", "fallo", time() + (86400 * 30), "/");
            }

            header('Location: index.php?route=user/manage');
        }
    }
