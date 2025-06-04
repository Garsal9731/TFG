<?php

    // Definimos el namespace de Core
    namespace App\Core;

    // ? Por defecto si hay un namespace busca las clases en el namespace en lugar de las nativas de PHP (IDK)
    use \PDO as PDO;

    class Database {
        
        private static $instance = null;
        private $pdo;

        // Constructor
        /**
         * @param VOID NULL
         * 
         * Crea la conexión a la base de datos usando los datos de la propia
         */
        private function __construct() {
            // $host = 'localhost';
            // $dbName = 'gestor_rei';
            // $user = 'root';
            // $password = '123456';
            $host = 'mysql.cifpceuta.es';
            $dbName = 'gestorei';
            $user = 'gestorei';
            $password = 'f#7v58e3L';

            try {
                $this->pdo = new PDO(
                    "mysql:host=$host;dbname=$dbName;charset=utf8",
                    $user,
                    $password
                );
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $error) {
                echo "<p id='mensajeError' hidden>".$error->getMessage()."</p>";
            }
        }

        // Recoger Instancia
        /**
         * @param VOID NULL
         * 
         * Recoge la conexión a base de datos actual, la instancia y si no la hay llama al constructor
         */
        public static function getInstance() {

            if (self::$instance === null) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        // Recoger Conexión
         /**
         * @param VOID NULL
         * 
         * Recoger la conexión a base de datos actual
         */
        public function getConnection() {
            return $this->pdo;
        }
    }