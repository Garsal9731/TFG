<?php

    abstract class ConexionDB{
        private static $server = 'localhost';
        private static $db = 'tiendadetiendas';
        private static $user = 'root';
        private static $password = '123456';
    
        public static function connectDB() {
            try{
                $conexion = new PDO("mysql:host=".self::$server.";dbname=".self::$db.";charset=utf8", self::$user, self::$password);
            }catch(PDOException $error){
                echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
                die ("Error: " . $error->getMessage());
            }
    
            return $conexion;
        }
    }