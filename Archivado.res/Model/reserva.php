<?php
    require 'producto.php';

    class Reserva{

        private int $id;
        private int $usuario;
        private string $productos;
        private float $precio;

        function __construct($id, $usuario, $productos, $precio){
            $this->id = $id;
            $this->usuario = $usuario;
            $this->productos = $productos;
            $this->precio = $precio;
        }

        public function getId(){
            return $this->id;
        }
        public function getUsuario(){
            return $this->usuario;
        }
        public function getProductos(){
            $productos = $this->productos;
            $cantidadProductos = strlen($productos);
            $arrayProductos = [];
            for($contador=0;$contador<$cantidadProductos;$contador++){
                array_push($arrayProductos,$productos[$contador]);
            }

            return $arrayProductos;
        }
        public function getPrecio(){
            return $this->precio;
        }

        public function getNombreProductos(){
            $conexion = ConexionDB::connectDB();
            

            $productos = $this->productos;
            $cantidadProductos = strlen($productos);
            $nombres = [];
            for($contador=0;$contador<$cantidadProductos;$contador++){
                $seleccion = "SELECT nombre FROM productos WHERE idproducto='".$productos[$contador]."';";
                $consulta = $conexion->query($seleccion);
                $registro = $consulta->fetch(PDO::FETCH_ASSOC);
                array_push($nombres,$registro["nombre"]);
            }

            return $nombres;
        }

        public function registrar(){
            $conexion = ConexionDB::connectDB();
            $insercion = 'INSERT INTO reservas (usuario, productos, precio) VALUES ("'.$this->usuario.'", "'.$this->productos.'", "'.$this->precio.'");';
            $conexion->exec($insercion);
        }

        public function eliminar(){
            $conexion = ConexionDB::connectDB();
            $borrado = 'DELETE FROM reservas WHERE idreserva="'.$this->id.'";';
            $conexion->exec($borrado);
        }

        public static function getReservas(){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idreserva, usuario, productos, precio FROM reservas;";
            $consulta = $conexion->query($seleccion);
            
            $reservas = [];
            
            while($registro = $consulta->fetchObject()){
                $reservas[] = new Reserva($registro->idreserva, $registro->usuario, $registro->productos, $registro->precio);
            }
        
            return $reservas;    
        }
        public static function getReservaById($id){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idreserva, usuario, productos, precio FROM reservas WHERE idreserva='".$id."';";
            $consulta = $conexion->query($seleccion);
            $registro = $consulta->fetchObject();
            $usuario = new Reserva($registro->idreserva, $registro->usuario, $registro->productos, $registro->precio);
            
            return $usuario;    
        }
        public static function getReservasByUsuario($idusuario){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idreserva, usuario, productos, precio FROM reservas WHERE usuario='".$idusuario."';";
            $consulta = $conexion->query($seleccion);
            
            $reservas = [];
            
            while($registro = $consulta->fetchObject()){
                $reservas[] = new Reserva($registro->idreserva, $registro->usuario, $registro->productos, $registro->precio);
            }
        
            return $reservas;
        }

    }