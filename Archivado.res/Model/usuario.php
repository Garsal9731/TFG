<?php

    require 'conectorBD.php';

    class Usuario{

        private int $id;
        private string $nombre;
        private string $contra;
        private int $privilegio;
        private string $correo;
        private string $descripcion;

        function __construct($id, $nombre, $contra, $privilegio, $correo, $descripcion){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->contra = $contra;
            $this->privilegio = $privilegio;
            $this->correo = $correo;
            $this->descripcion = $descripcion;
        }

        // Setters
        public function setId($id){
            $this->id = $id;
        }
        public function setNombre($nombre){
            $this->nombre = $nombre;
        }
        public function setContra($contra){
            $this->contra = $contra;
        }
        public function setPriv($privilegio){
            $this->privilegio = $privilegio;
        }
        public function setCorreo($correo){
            $this->correo = $correo;
        }
        public function setDesc($desc){
            $this->descripcion = $desc;
        }
        // Getters
        public function getId(){
            return $this->id;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function getContra(){
            return $this->contra;
        }
        public function getPriv(){
            return $this->privilegio;
        }
        public function getCorreo(){
            return $this->correo;
        }
        public function getDesc(){
            return $this->descripcion;
        }

        public function buscarId(){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idusuario FROM usuarios WHERE nombre=".$this->nombre." AND privilegio=".$this->privilegio." AND correo=".$this->correo." AND contrasenya=".$this->contra.";";
            $consulta = $conexion->query($seleccion);
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            $this->id = $resultado["idusuario"];
            
            return $this->id;
        }

        public function registrar(){
            $conexion = ConexionDB::connectDB();
            $insercion = 'INSERT INTO usuarios (nombre, contrasenya, privilegio, correo, descripcion) VALUES ("'.$this->nombre.'", "'.$this->contra.'", "'.$this->privilegio.'", "'.$this->correo.'", "'.$this->descripcion.'");';
            $conexion->exec($insercion);
        }

        public function eliminar(){
            $conexion = ConexionDB::connectDB();
            $borrado = 'DELETE FROM usuarios WHERE idusuario="'.$this->id.'";';
            $conexion->exec($borrado);
        }

        public static function getUsuarios(){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idusuario, nombre, contrasenya, privilegio, correo FROM usuarios;";
            $consulta = $conexion->query($seleccion);
            
            $usuarios = [];
            
            while($registro = $consulta->fetchObject()){
              $usuarios[] = new Usuario($registro->idusuario, $registro->nombre, $registro->contrasenya, $registro->privilegio, $registro->correo);
            }
           
            return $usuarios;    
        }
        public static function getUsuariosNombre($nombre){
            $conexion = ConexionDB::connectDB();

            $seleccion = "SELECT idusuario, nombre, contrasenya, privilegio, correo, descripcion FROM usuarios WHERE nombre='".$nombre."';";

            $consulta = $conexion->query($seleccion);
            
            $usuarios = [];
            
            while($registro = $consulta->fetchObject()){
                var_dump($registro);

              $usuarios[] = new Usuario($registro->idusuario, $registro->nombre, $registro->contrasenya, $registro->privilegio, $registro->correo, $registro->descripcion);
            }
           
            return $usuarios;    
        }
        public static function getUsuarioById($id){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idusuario, nombre, contrasenya, privilegio, correo FROM usuarios WHERE idusuario='".$id."';";
            $consulta = $conexion->query($seleccion);
            $registro = $consulta->fetchObject();
            $usuario = new Usuario($registro->idusuario, $registro->nombre, $registro->contrasenya, $registro->privilegio, $registro->correo);
               
            return $usuario;    
        }

        public function validarUsuario(){

            // Usamos el metodo estatico para buscar usuarios usando el nombre del objeto
            $usuarios = Usuario::getUsuariosNombre($this->nombre);

            // Comprobamos todos los usuarios y si nuestra contraseña puede verificar el hash del usuario, si lo hace inicia sesión
            foreach($usuarios as $usuario){
                $hash = $usuario->getContra();
                if(password_verify($this->contra, $hash)){
                    $this->id = $usuario->getId();
                    $this->contra = $hash;
                    $this->privilegio = $usuario->getPriv();
                    $this->correo = $usuario->getCorreo();
                    $this->descripcion = $usuario->getDesc();
                    return true;
                }
            }
            return false;
        }
    }
