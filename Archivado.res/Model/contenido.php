<?php

    require 'archivo.php';

    class Contenido{

        private int $id;
        private string $nombre;
        private string $tipo;
        private int $autor;
        private string $autor_original;
        private string $detalles = "";
        private string $fecha;

        // Ids Externas
        private string $id_archivos;
        private int $id_autor;

        function __construct($id, $nombre, $tipo, $autor, $autor_original,$detalles,$id_archivos,$id_autor,$fecha){
            $this->id = $id;
            $this->nombre = $nombre;
            $this->tipo = $tipo;
            $this->autor = $autor;
            $this->autor_original = $autor_original;
            $this->detalles = $detalles;
            $this->id_archivos = $id_archivos;
            $this->id_autor = $id_autor;
            $this->fecha = $fecha;
        }

        // Setters
            public function setId($id){
                $this->id = $id;
            }
            public function setNombre($nombre){
                $this->nombre = $nombre;
            }
            public function setTipo($tipo){
                $this->tipo = $tipo;
            }
            public function setAutor($autor){
                $this->autor = $autor;
            }
            public function setAutorOg($autor_original){
                $this->autor_original = $autor_original;
            }
            public function setDetalles($detalles){
                $this->detalles = $detalles;
            }
            public function setIdArch($id_archivos){
                $this->id_archivos = $id_archivos;
            }
            public function setIdAutor($id_autor){
                $this->$id_autor = $id_autor;
            }
            public function setFecha($fecha){
                $this->fecha = $fecha;
            }

        // Getters
            public function getId(){
                return $this->id;
            }
            public function getNombre(){
                return $this->nombre;
            }
            public function getTipo(){
                return $this->tipo;
            }
            public function getAutor(){
                return $this->autor;
            }
            public function getAutorOg(){
                return $this->autor_original;
            }
            public function getDetalles(){
                return $this->detalles;
            }
            public function getIdArch(){
                return $this->id_archivos;
            }
            public function getIdAutor(){
                return $this->$id_autor;
            }
            public function getFecha(){
                return $this->fecha;
            }

        public function registrarContenido(){
            $conexion = ConexionDB::connectDB();
            $insercion = 'INSERT INTO contenido (tipo_contenido, nombre, detalles, Autor_original, Autor_post, Archivos, fecha_subida) VALUES ("'.$this->tipo.'", "'.$this->nombre.'", "'.$this->detalles.'", "'.$this->autor_original.'", '.$this->autor.', "'.$this->id_archivos.'", "'.$this->fecha.'");';
            $conexion->exec($insercion);
        }

        public static function recogerPosts(){
            $conexion = ConexionDB::connectDB();
            $seleccion = "SELECT * FROM contenido ORDER BY -fecha_subida;";
            $consulta = $conexion->query($seleccion);
            
            $posts = [];
            
            while($registro = $consulta->fetchObject()){
                $posts[] = new Contenido($registro->idpost, $registro->nombre, $registro->tipo_contenido, $registro->Autor_post, $registro->Autor_original, $registro->detalles,  $registro->Archivos, $registro->Autor_post, $registro->fecha_subida);
            }
           
            return $posts; 
        }

        public static function getNombreAutorById($id){
            $conexion = ConexionDB::connectDB();

            $seleccion = "SELECT nombre FROM usuarios WHERE idusuario='".$id."';";
            $consulta = $conexion->query($seleccion);
            $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
            
            if($resultado["nombre"]==null){
                $nombre = "ELIMINADO";
            }else{
                $nombre = $resultado["nombre"];
            }

            return $nombre;
        }
    }
