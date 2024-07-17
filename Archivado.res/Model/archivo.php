<?php

    require 'conectorBD.php';

    class Archivo{

        private int $id;
        private string $usuario_subida;
        private string $descripcion;
        private string $ruta_archivo;

        function __construct($id, $usuario_subida, $descripcion, $ruta_archivo){
            $this->id = $id;
            $this->usuario_subida = $usuario_subida;
            $this->getDescripcion = $descripcion;
            $this->ruta_archivo = $ruta_archivo;
        }

        // Getters
            public function getId(){
                return $this->id;
            }
            public function getUsuario(){
                return $this->usuario_subida;
            }
            public function getDesc(){
                return $this->descripcion;
            }
            public function getRuta_archivo(){
                return $this->ruta_archivo;
            }

        // public static function aumentarStock(int $id){

        //     $stock = Producto::getStock($id);
        //     $stockAumentado = $stock+1;
            
        //     $conexion = ConexionDB::connectDB();
        //     $actualizacion = 'UPDATE productos SET unidades="'.$stockAumentado.'" WHERE idproducto="'.$id.'";';
        //     $conexion->exec($actualizacion);
        // }

    }