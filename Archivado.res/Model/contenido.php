<?php

    require 'conectorBD.php';

    class Contenido{

        private int $id;
        private string $tipo;
        private int $autor;
        private string $autor_original;
        private string $detalles = "";

        // Ids Externas
        private int $id_archivos;
        private int $id_autor;

        function __construct($id, $tipo, $autor, $autor_original,$detalles,$id_archivos,$id_autor){
            $this->id = $id;
            $this->tipo = $tipo;
            $this->autor = $autor;
            $this->autor_original = $autor_original;
            $this->detalles = $detalles;
            $this->id_archivos = $id_archivos;
            $this->$id_autor = $id_autor;
        }

        // Setters
            public function setId($id){
                $this->id = $id;
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

        // Getters
            public function getId(){
                return $this->id;
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
    }
