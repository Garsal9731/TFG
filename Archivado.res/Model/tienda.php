<?php

    require 'conectorBD.php';

    class Tienda{

        private int $id;
        private string $nombre;
        private int $propietario;
        private string $descripcion;

        function __construct($id, $nombre, $propietario, $descripcion){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->propietario = $propietario;
            $this->descripcion = $descripcion;
        }

        public function getId(){
            return $this->id;
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function getPropietario(){
            return $this->propietario;
        }
        public function getDescripcion(){
            return $this->descripcion;
        }

        public function registrar(){
            $conexion = ConexionDB::connectDB();
            $insercion = 'INSERT INTO tiendas(nombre, idpropietario, descripcion) VALUES ("'.$this->nombre.'", "'.$this->propietario.'", "'.$this->descripcion.'");';
            $conexion->exec($insercion);
        }

        public function eliminar(){
            $conexion = ConexionDB::connectDB();
            $borrado = 'DELETE FROM tiendas WHERE idtienda="'.$this->id.'";';
            $conexion->exec($borrado);
        }

        public static function getTiendas(){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idtienda, nombre, idpropietario, descripcion FROM tiendas;";
            $consulta = $conexion->query($seleccion);
            
            $tiendas = [];
            
            while($registro = $consulta->fetchObject()){
              $tiendas[] = new Tienda($registro->idtienda, $registro->nombre, $registro->idpropietario, $registro->descripcion);
            }
           
            return $tiendas;    
        }
        public static function getTiendaById($id){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idtienda, nombre, idpropietario, descripcion FROM tiendas WHERE idtienda='".$id."';";
            $consulta = $conexion->query($seleccion);
            $registro = $consulta->fetchObject();
            $tienda = new Tienda($registro->idtienda, $registro->nombre, $registro->idpropietario, $registro->descripcion);
               
            return $tienda;    
        }
        public static function getTiendaByPropietario($propietario){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idtienda, nombre, idpropietario, descripcion FROM tiendas WHERE idpropietario='".$propietario."';";
            $consulta = $conexion->query($seleccion);
            $registro = $consulta->fetchObject();
            $tienda = new Tienda($registro->idtienda, $registro->nombre, $registro->idpropietario, $registro->descripcion);
               
            return $tienda;    
        }
        public static function getPropietarioById($id){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idusuario, nombre, contrasenya, privilegio, correo FROM usuarios WHERE idusuario='".$id."';";
            $consulta = $conexion->query($seleccion);
            $registro = $consulta->fetch(PDO::FETCH_ASSOC);
               
            return $registro;    
        }
        public static function getProductos($tienda){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idproducto, nombre, descripcion, rutafoto, unidades, precio FROM productos WHERE tienda='".$tienda."';";
            $consulta = $conexion->query($seleccion);
            $registro = $consulta->fetchAll(PDO::FETCH_ASSOC);
               
            return $registro;    
        }
    }
