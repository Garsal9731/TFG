<?php

    // ? EmptyModel actúa como plantilla para el resto de clases (Lleva funciones que usan la mayoría de clases)
    // ? Namespace actúa como la ruta (Define la ruta sín incluir la clase o archivo, a no ser que sea llamado por un archivo externo/no relacionado)
    // Definimos el namespace (Será heredado por el resto de clases que se enlacen a este archivo)
    namespace App\Core;

    // Anclamos el archivo con la clase que usa la BD
    require_once __DIR__ .'/./Database.php';

    // Le damos un alias a la ruta del namespace de la base de datos
    use App\Core\Database as Database;
    use \PDO as PDO;

    // ? EmptyModel actúa como plantilla para el resto de clases (Lleva funciones que usan la mayoría de clases)
    class EmptyModel {
        protected $db;
        protected $table;
        protected $primaryKey;

        // Constructor
        /**
         * @param $tabla string
         * @param $clavePrimaria string
         * 
         * Es el constructor de la clase
         */
        public function __construct($table, $primaryKey = 'id') {
            $this->db = Database::getInstance()->getConnection();
            $this->table = $table;
            $this->primaryKey = $this->getPrimary($table);
        }

        // Realizar Consulta
        /**
         * @param $sql string
         * @param $params array
         * 
         * Manda consultas ya preparadas a la base de datos y devuelve la respuesta si hay una
         */
        protected function query($sql, $params = []) {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }

        // Recoger Primaria
        /**
         * @param $table string
         * 
         * Manda una consulta a la base de datos y recoge la clave primaria de la tabla
         */
        public function getPrimary($table){
            $sql = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY';";
            $keys = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $keys["Column_name"];
        }

        // Recoger última id
        /**
         * @param VOID NULL
         * 
         * Manda una consulta a la base de datos y recoge el último registro de la clave primaria
         */
        public function getLastId(){
            $sql = "SELECT {$this->primaryKey} FROM {$this->table} ORDER BY {$this->primaryKey} DESC LIMIT 1;";
            $lastId = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $lastId["{$this->primaryKey}"];
        }

        // Recoger todo
        /**
         * @param VOID NULL
         * 
         * Recoge todos los registros de la tabla actual
         */
        public function getAll(){
            $sql = "SELECT * FROM {$this->table}";
            return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        // Registros por principal
        /**
         * @param $id int
         * 
         * Recoge el registro completo usando la id principal de la tabla
         */
        public function getById($id) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
            return $this->query($sql, [$id])->fetch(PDO::FETCH_ASSOC);
        }

        // Crear registro
        /**
         * @param $datos string
         * 
         * Divide el string de datos usando la , y los coloca de manera que se pueden convertir en un registro y añadirse a la base de datos
         */
        public function create($data) {
            $fields = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
            $this->query($sql, array_values($data));
            return $this->db->lastInsertId();
        }

        // Actualizar usando primaria
        /**
         * @param $datos string
         * @param $id int
         * 
         * Divide el string de datos para adaptarlos a un registro y lo actualiza usando la id principal
         */
        public function update($data, $id) {
            $setClause = implode(', ', array_map(fn($field) => "{$field} = ?", array_keys($data)));
            $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
            $this->query($sql, array_merge(array_values($data), [$id]));
        }

        // Eliminar un registro por clave primaria
        /**
         * @param $id int
         * 
         * Borra el registro de la tabla actual usando la id
         */
        public function delete($id) {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
            $this->query($sql, [$id]);
        }

        // Recoger Institución del usuario actúal
        /**
         * @param $id int
         * 
         * Recoge la id de la institución en la que trabaja el usuario usando una consulta preparada (en EmptyModel porque lo usan varias clases)
         */
        public function getUserInst($id) {
            $sql = "SELECT * FROM Institución WHERE Id_Institución LIKE (SELECT Institución_Id_Institución FROM Trabajadores_Institución WHERE Usuario_Id_Usuario LIKE $id);";
            $inst = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $inst;
        }
    }