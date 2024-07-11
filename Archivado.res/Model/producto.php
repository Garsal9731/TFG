<?php

    require 'conectorBD.php';

    class Producto{

        private int $id;
        private int $tienda;
        private string $nombre;
        private string $descripcion;
        private string $rutafoto;
        private int $unidades;
        private float $precio;

        function __construct($id, $tienda, $nombre, $descripcion, $rutafoto, $unidades, $precio){
            $this->id = $id;
            $this->tienda = $tienda;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->rutafoto = $rutafoto;
            $this->unidades = $unidades;
            $this->precio = $precio;
        }

        public function getId(){
            return $this->id;
        }
        public function getTienda(){
            return $this->tienda;
        }
        public function getNombreTienda(){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT nombre FROM tiendas WHERE idtienda='".$this->tienda."';";
            $consulta = $conexion->query($seleccion);
            
            $registro = $consulta->fetch(PDO::FETCH_ASSOC);
           
            return $registro["nombre"];
        }
        public function getNombre(){
            return $this->nombre;
        }
        public function getDescripcion(){
            return $this->descripcion;
        }
        public function getFoto(){
            return $this->rutafoto;
        }        
        public function getUnidades(){
            return $this->unidades;
        }
        public function getPrecio(){
            return $this->precio;
        }

        public function registrar(){
            $conexion = ConexionDB::connectDB();
            $insercion = 'INSERT INTO productos(tienda, nombre, descripcion, rutafoto, unidades, precio) VALUES ("'.$this->tienda.'", "'.$this->nombre.'", "'.$this->descripcion.'", "'.$this->rutafoto.'", "'.$this->unidades.'", "'.$this->precio.'");';
            $conexion->exec($insercion);
        }

        public function actualizar(){
            $conexion = ConexionDB::connectDB();
            $actualizacion = 'UPDATE productos SET tienda="'.$this->tienda.'", nombre="'.$this->nombre.'", descripcion="'.$this->descripcion.'", rutafoto="'.$this->rutafoto.'", unidades="'.$this->unidades.'", precio="'.$this->precio.'" WHERE idproducto="'.$this->id.'";';
            $conexion->exec($actualizacion);
        }

        public function borrar(){
            $conexion = ConexionDB::connectDB();
            $borrado = 'DELETE FROM productos WHERE idproducto="'.$this->id.'";';
            $conexion->exec($borrado);

            unlink($this->rutafoto);
        }

        public function getProveedor(){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT us.nombre, us.idusuario FROM usuarios us inner JOIN tiendas ts JOIN productos pd ON us.idusuario=ts.idpropietario and ts.idtienda=pd.tienda WHERE pd.tienda=".$this->tienda." Limit 1;";
            $consulta = $conexion->query($seleccion);
            $registro = $consulta->fetch(PDO::FETCH_ASSOC);
        }

        public static function getProductos(){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idproducto, tienda, nombre, descripcion, rutafoto, unidades, precio FROM productos;";
            $consulta = $conexion->query($seleccion);
            
            $productos = [];
            
            while($registro = $consulta->fetchObject()){
              $productos[] = new Producto($registro->idproducto, $registro->tienda, $registro->nombre, $registro->descripcion, $registro->rutafoto, $registro->unidades, $registro->precio);
            }
           
            return $productos;    
        }
        public static function getProductoById($id){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idproducto, tienda, nombre, descripcion, rutafoto, unidades, precio FROM productos WHERE idProducto='".$id."';";
            $consulta = $conexion->query($seleccion);
            $registro = $consulta->fetchObject();
            $producto = new Producto($registro->idproducto, $registro->tienda, $registro->nombre, $registro->descripcion, $registro->rutafoto, $registro->unidades, $registro->precio);
               
            return $producto;    
        }
        public static function getUltimaId(){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT idproducto FROM productos ORDER BY idproducto DESC LIMIT 1;";
            $consulta = $conexion->query($seleccion);
            
            $registro = $consulta->fetch(PDO::FETCH_ASSOC);
              
            if($registro==false){
                $registro=array("idproducto"=>0);
            }
           
            return $registro;
        }
        public static function getStock($id){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT unidades FROM productos WHERE idproducto='".$id."';";
            $consulta = $conexion->query($seleccion);
            
            $registro = $consulta->fetch(PDO::FETCH_ASSOC);

            $stock = $registro["unidades"];
           
            return $stock;
        }
        public static function reducirStock(int $id){

            $stock = Producto::getStock($id);
            $stockReducido = $stock-1;
            
            $conexion = ConexionDB::connectDB();
            $actualizacion = 'UPDATE productos SET unidades="'.$stockReducido.'" WHERE idproducto="'.$id.'";';
            $conexion->exec($actualizacion);
        }
        public static function aumentarStock(int $id){

            $stock = Producto::getStock($id);
            $stockAumentado = $stock+1;
            
            $conexion = ConexionDB::connectDB();
            $actualizacion = 'UPDATE productos SET unidades="'.$stockAumentado.'" WHERE idproducto="'.$id.'";';
            $conexion->exec($actualizacion);
        }

    }