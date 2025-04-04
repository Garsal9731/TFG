<?php

    // ? EmptyModel actúa como plantilla para el resto de clases (Lleva funciones que usan la mayoría de clases)
    class EmptyModel {

        // Constructor
        /**
         * $tabla string
         * $clavePrimaria string
         * 
         * Es el constructor de la clase
         */


        // Realizar Consulta
        /**
         * $sql string
         * $params array
         * 
         * Manda consultas ya preparadas a la base de datos y devuelve la respuesta si hay una
         */


        // Recoger todo
        /**
         * VOID NULL
         * 
         * Recoge todos los registros de la tabla actual
         */


        // Registros por principal
        /**
         * $id int
         * 
         * Recoge el registro completo usando la id principal de la tabla
         */


        // Crear registro
        /**
         * $datos string
         * 
         * Divide el string de datos usando la , y los coloca de manera que se pueden convertir en un registro y añadirse a la base de datos
         */


        // Actualizar usando primaria
        /**
         * $datos string
         * $id int
         * 
         * Divide el string de datos para adaptarlos a un registro y lo actualiza usando la id principal
         */

        // Eliminar registro usando clave primaria
        /**
         * $id int
         * 
         * Borra el registro de la tabla actual usando la id
         */
    }