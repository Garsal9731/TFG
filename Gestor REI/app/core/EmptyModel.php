<?php

    // ? EmptyModel actúa como plantilla para el resto de clases (Lleva funciones que usan la mayoría de clases)
    // ? Namespace actúa como la ruta (Define la ruta sín incluir la clase o archivo, a no ser que sea llamado por un archivo externo/no relacionado)
    // Definimos el namespace (Será heredado por el resto de clases que se enlacen a este archivo)
    namespace App\Core;

    // Anclamos el archivo con la clase que usa la BD
    require_once __DIR__ .'/./Database.php';
    require_once __DIR__ .'/./security.php';

    // Le damos un alias a la ruta del namespace de la base de datos
    use App\Core\Database as Database;
    use \PDO as PDO;

    // ? EmptyModel actúa como plantilla para el resto de clases (Lleva funciones que usan la mayoría de clases)
    class EmptyModel {
        protected $db;
        protected $table;
        protected $primaryKey;

        /**
         * Constructor Base de Datos
         * 
         * Constructor de la base de datos.
         * 
         * @param string $tabla Nombre de la tabla a buscar en la base de datos.
         * @param string $primaryKey Por defecto la clave primaria de todas las tablas es "id", pero se actualiza automaticamente usando el nombre de la tabla.
         * 
         * @return void
         */
        public function __construct($table, $primaryKey = 'id') {
            $this->db = Database::getInstance()->getConnection();
            $this->table = $table;
            $this->primaryKey = $this->getPrimary($table);
        }

        /**
         * Realizar Consulta
         * 
         * Manda consultas ya preparadas a la base de datos y devuelve la respuesta si hay una
         * 
         * @param string $sql Hilo a buscar en la base de datos.
         * @param array $params Array de parametros para usar en la busqueda.
         * 
         * @return array $stmt Array de resultados de la busqueda.
         */
        protected function query($sql, $params = []) {
            try{
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);
                return $stmt;
            }catch(Exception $error){
                Security::generateErrors("consulta");
            }
        }

        /**
         * Recoger Primaria
         * 
         * Manda una consulta a la base de datos y recoge la clave primaria de la tabla.
         * 
         * @param string $table Nombre de la tabla.
         * 
         * @return string Nombre de la clave principal de la tabla actual.
         */
        public function getPrimary($table){
            $sql = "SHOW KEYS FROM $table WHERE Key_name = 'PRIMARY';";
            $keys = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $keys["Column_name"];
        }

        /**
         * Recoger última id
         * 
         * Manda una consulta a la base de datos y recoge el último registro de la clave primaria.
         * 
         * @param void
         * 
         * @return int $lastId Ultima Id registrada de la tabla actual.
         */
        public function getLastId(){
            $sql = "SELECT {$this->primaryKey} FROM {$this->table} ORDER BY {$this->primaryKey} DESC LIMIT 1;";
            $lastId = $this->query($sql)->fetch(PDO::FETCH_ASSOC);
            return $lastId["{$this->primaryKey}"];
        }

        /**
         * Recoger todo
         * 
         * Recoge todos los registros de la tabla actual.
         * 
         * @param void
         * 
         * @return array Array con todos los registros de la tabla actual.
         */
        public function getAll(){
            $sql = "SELECT * FROM {$this->table}";
            return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Registros por principal
         * 
         * Recoge el registro completo usando la id principal de la tabla. 
         * 
         * @param int $id id del registro a buscar.
         * 
         * @return array Array con los datos del registro.
         */
        public function getById($id) {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
            return $this->query($sql, [$id])->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Crear registro
         * 
         * Divide el string de datos usando la , y los coloca de manera que se pueden convertir en un registro y añadirse a la base de datos.
         * 
         * @param string $datos Datos con los que vamos a crear el registro.
         * 
         * @return int Ultima Id insertada de la tabla actual.
         */
        public function create($data) {
            $fields = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $sql = "INSERT INTO {$this->table} ({$fields}) VALUES ({$placeholders})";
            $this->query($sql, array_values($data));
            return $this->db->lastInsertId();
        }

        /**
         * Actualizar usando primaria
         * 
         * Divide el string de datos para adaptarlos a un registro y lo actualiza usando la id principal.
         * 
         * @param string $datos Datos a actualizar en el registro de la base de datos.
         * @param int $id Id del registro a actualizar.
         * 
         * @return void
         */
        public function update($data, $id) {
            $setClause = implode(', ', array_map(fn($field) => "{$field} = ?", array_keys($data)));
            $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
            $this->query($sql, array_merge(array_values($data), [$id]));
        }

        /**
         * Eliminar un registro por clave primaria
         * 
         * Borra el registro de la tabla actual usando la id.
         * 
         * @param int $id Id del registro a borrar.
         * 
         * @return void
         */
        public function delete($id) {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
            $this->query($sql, [$id]);
        }
    }