<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class SubcategoriaQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_subcategoria, nombre_sub, descripcion_sub, imagen, nombre_categoria
        FROM subcategorias
        INNER JOIN categorias USING(id_categoria)
        WHERE nombre_sub ILIKE ? OR descripcion_sub ILIKE ?
        ORDER BY nombre_sub;';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    //Método para insertar datos a la tabla de productos por medio de una query 
    public function createRow()
    {
        $sql = 'INSERT INTO subcategorias(
            nombre_sub, descripcion_sub, imagen, id_categoria)
            VALUES (?, ?, ?, ?);';
        $params = array($this->nombre, $this->descripcion, $this->imagen, $this->categoria);
        return Database::executeRow($sql, $params);
    }

    //Método para leer los registros de la tabla ordenandolos por sus nombres de subcategorías por medio de una query general a la tabla
    public function readAll()
    {
        $sql = 'SELECT id_subcategoria, nombre_sub, descripcion_sub, imagen, nombre_categoria
                FROM subcategorias
                INNER JOIN categorias USING(id_categoria)
                ORDER BY nombre_sub';
        return Database::getRows($sql);
    }

    //Método para consultar una columna específica de la tabla por medio de su id
    public function readOne()
    {
        $sql = 'SELECT id_subcategoria, nombre_sub, descripcion_sub, imagen, id_categoria
                FROM subcategorias
                INNER JOIN categorias USING(id_categoria)
                WHERE id_subcategoria = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar la actualización de la tabla por medio de una query parametrizada
    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE subcategorias
                SET nombre_sub=?, descripcion_sub=?, imagen=?, id_categoria=?
                WHERE id_subcategoria=?';
        $params = array($this->nombre, $this->descripcion, $this->imagen, $this->categoria, $this->id);
        return Database::executeRow($sql, $params);
    }

    //Metodo para eliminar un dato de la tabla por medio del id
    public function deleteRow()
    {
        $sql = 'DELETE FROM subcategorias
                WHERE id_subcategoria = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    //Metodo para consultar datos de la tabla categorias y llenar los datos del select
    public function readCategorias()
    {
        $sql = 'SELECT id_categoria, nombre_categoria, descripcion_categoria
                FROM categorias';
            return Database::getRows($sql);
    }
}