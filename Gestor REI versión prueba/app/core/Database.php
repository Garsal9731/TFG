<?php

    // Definimos el namespace de Core
    namespace App\Core;

    // ? Por defecto si hay un namespace busca las clases en el namespace en lugar de las nativas de PHP (IDK)
    use \PDO as PDO;

    class Database {
        
        private static $instance = null;
        private $pdo;

        private function __construct() {
            $host = 'localhost';
            // $dbName = 'gestor_rei';
            $dbName = 'mvc_example';
            $user = 'root';
            $password = '123456';

            try {
                $this->pdo = new PDO(
                    "mysql:host=$host;dbname=$dbName;charset=utf8",
                    $user,
                    $password
                );
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }

        public static function getInstance() {

            if (self::$instance === null) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function getConnection() {
            return $this->pdo;
        }
    }