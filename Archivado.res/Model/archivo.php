<?php

    require 'conectorBD.php';

    class Archivo{

        private int $id;
        private string $usuario_subida;
        private string $descripcion;
        private string $ruta_archivo;
        private string $nombre;

        function __construct($id, $usuario_subida, $descripcion, $ruta_archivo, $nombre){
            $this->id = $id;
            $this->usuario_subida = $usuario_subida;
            $this->getDescripcion = $descripcion;
            $this->ruta_archivo = $ruta_archivo;
            $this->nombre = $nombre;
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
            public function getNombre(){
                return $this->nombre;
            }

        public function registrar(){
            
            $conexion = ConexionDB::connectDB();
            $actualizacion = 'INSERT INTO  unidades="'.$stockAumentado.'" WHERE idproducto="'.$id.'";';
            $conexion->exec($actualizacion);
        }

    }