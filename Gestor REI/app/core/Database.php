<?php

    // Definimos el namespace de Core
    namespace App\Core;

    // ? Por defecto si hay un namespace busca las clases en el namespace en lugar de las nativas de PHP (IDK)
    use \PDO as PDO;

    class Database {
        
        private static $instance = null;
        private $pdo;

        /**
         * Constructor Base de datos
         * 
         * Crea la conexión a la base de datos usando los datos de la propia.
         * 
         * @param void
         * 
         * @return void
         */
        private function __construct() {
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

        /**
         * Recoger Instancia
         * 
         * Recogemos la instancia de la conexión a la base de datos si existe, de no existir creamos una nueva.
         * 
         * @param void
         * 
         * @return array $instance Instancia de la conexión a la base de datos.
         */
        public static function getInstance() {

            if (self::$instance === null) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Recoger Conexión
         * 
         * Recogemos el PDO de la base de datos.
         * 
         * @param void
         * 
         * @return array $pdo PDO de la base de datos.
         */
        public function getConnection() {
            return $this->pdo;
        }
    }