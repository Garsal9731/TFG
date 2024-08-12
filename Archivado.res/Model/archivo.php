<?php

    require 'conectorBD.php';

    class Archivo{

        private int $id;
        private int $usuario_subida;
        private string $formato;
        private string $ruta_archivo;
        private string $nombre;

        function __construct($id, $usuario_subida, $formato, $ruta_archivo, $nombre){
            $this->id = $id;
            $this->usuario_subida = $usuario_subida;
            $this->formato = $formato;
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
            public function getFormato(){
                return $this->formato;
            }
            public function getRuta_archivo(){
                return $this->ruta_archivo;
            }
            public function getNombre(){
                return $this->nombre;
            }

        public function registrar(){
                
            $conexion = ConexionDB::connectDB();

            $registro = "INSERT INTO archivos (usuario_subida, formato, ruta_archivo, nombre) VALUES ('".$this->usuario_subida."', '".$this->formato."', '".$this->ruta_archivo."','".$this->nombre."');";
            $conexion->exec($registro);
        }

        // ? Usar esta función antes de registrar el archivo o la id no será la misma
        public static function siguienteId(){

            $conexion = ConexionDB::connectDB();

            $seleccion = "SELECT idarchivo FROM archivos ORDER BY -idarchivo LIMIT 1;";
            $consulta = $conexion->query($seleccion);
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            
            if($resultado["idarchivo"]==null){
                $siguienteId = 1;
            }else{
                $siguienteId = $resultado["idarchivo"]+1;
            }

            return $siguienteId;
        }
    }