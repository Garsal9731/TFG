<?php

    require 'usuario.php';

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

        public static function borrarPost($idpost){
            $conexion = ConexionDB::connectDB();
            
            $registro = "DELETE FROM contenido WHERE idpost=".$idpost.";";
            $conexion->exec($registro);
        }

        public static function modificarArchivosPost($idpost,$arrayCodificado){
            $conexion = ConexionDB::connectDB();
            $actualizacion = "UPDATE contenido SET Archivos='".$arrayCodificado."' WHERE idpost=".$idpost.";";
            $conexion->exec($actualizacion);
        }

        public static function borrarPorId($id,$ruta){
            $conexion = ConexionDB::connectDB();
            
            $registro = "DELETE FROM archivos WHERE idarchivo=".$id.";";
            $conexion->exec($registro);

            $seleccion = 'SELECT * FROM contenido WHERE Archivos LIKE "'."[".$id.",%".'" OR Archivos LIKE "['.$id.']" OR Archivos LIKE "%,'.$id.']" OR Archivos LIKE "%,'.$id.',%";';

            $consulta = $conexion->query($seleccion);
            
            $objetos = $consulta->fetchAll(PDO::FETCH_ASSOC);

            settype($id, "integer");
            foreach ($objetos as $objeto){
                $arrayArchivos = array();
                $archivos = json_decode($objeto["Archivos"]);

                foreach($archivos as $archivo){
                    if($id!==$archivo){
                        array_push($arrayArchivos,$archivo);
                    }
                }

                if(count($arrayArchivos)==0){
                    Archivo::borrarPost($objeto["idpost"]);
                }else{
                    Archivo::modificarArchivosPost($objeto["idpost"],json_encode($arrayArchivos));
                } 
            }

            unlink($ruta);
        }

        public static function cambiarRutaId($ruta,$id){

            $conexion = ConexionDB::connectDB();

            $actualizacion = "UPDATE archivos SET ruta_archivo='".$ruta."' WHERE idarchivo='".$id."';";
            $conexion->exec($actualizacion);
        }

        public static function ultimaId(){

            $conexion = ConexionDB::connectDB();

            $seleccion = "SELECT idarchivo FROM archivos ORDER BY -idarchivo LIMIT 1;";
            $consulta = $conexion->query($seleccion);
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            
            if($resultado["idarchivo"]==null){
                $ultimaId = 1;
            }else{
                $ultimaId = $resultado["idarchivo"];
            }

            return $ultimaId;
        }

        public static function getArchivoById($id){
            
            $conexion = ConexionDB::connectDB();
        
            $seleccion = 'SELECT * FROM archivos WHERE idarchivo="'.$id.'";';

            $consulta = $conexion->query($seleccion);
            
            $registro = $consulta->fetchObject();
            $archivo = new Archivo($registro->idarchivo, $registro->usuario_subida, $registro->formato, $registro->ruta_archivo, $registro->nombre);

            return $archivo;
        }

        public static function getArchivosByAutor($idAutor){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT * FROM archivos WHERE usuario_subida=".$idAutor.";";
            $consulta = $conexion->query($seleccion);
            
            $archivos = [];
            
            while($registro = $consulta->fetchObject()){
                $archivos[] = new Archivo($registro->idarchivo, $registro->usuario_subida, $registro->formato, $registro->ruta_archivo, $registro->nombre);
            }
           
            return $archivos; 
        }
    }