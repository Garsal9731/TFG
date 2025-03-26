<?php
    
    // ? Namespace actúa como la ruta (Define la ruta sín incluir la clase o archivo, a no ser que sea llamado por un archivo externo/no relacionado)
    // Definimos el namespace (Será heredado por el resto de clases que se enlacen a este archivo)
    namespace App\Models;

    // Anclamos el archivo con la clase que usa la BD
    require_once __DIR__ .'/../core/Database.php';

    // Le damos un alias a la ruta del namespace de la base de datos
    use App\Core\Database as Database;
    use \PDO as PDO;

    // ? EmptyModel actúa como plantilla para el resto de clases (Lleva funciones que usan la mayoría de clases)
    class EmptyModel {
        protected $db;
        protected $table;
        protected $primaryKey;

        // Constructor
        public function __construct($table, $primaryKey = 'id') {
            $this->db = Database::getInstance()->getConnection();
            $this->table = $table;
            $this->primaryKey = $primaryKey;
        }

        // Consultas preparadas
        protected function query($sql, $params = []) {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }

        // Obtener todos los registros
        public function getAll(){
            $sql = "SELECT * FROM {$this->table}";
            return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        // Obtener un registro por clave primaria
        public function getById($id) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
            return $this->query($sql, [$id])->fetch(PDO::FETCH_ASSOC);
        }

        // Crear un nuevo registro
        public function create($data) {
            $fields = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
            $this->query($sql, array_values($data));
            return $this->db->lastInsertId();
        }

        // Actualizar un registro por clave primaria
        public function update($data, $id) {
            $setClause = implode(', ', array_map(fn($field) => "{$field} = ?", array_keys($data)));
            $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
            $this->query($sql, array_merge(array_values($data), [$id]));
        }

        // Eliminar un registro por clave primaria
        public function delete($id) {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
            $this->query($sql, [$id]);
        }
    }