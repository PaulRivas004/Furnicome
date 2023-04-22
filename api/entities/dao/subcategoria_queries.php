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

    public function createRow()
    {
        $sql = 'INSERT INTO subcategorias(
            nombre_sub, descripcion_sub, imagen, id_categoria)
            VALUES (?, ?, ?, ?);';
        $params = array($this->nombre, $this->descripcion, $this->imagen, $this->categoria);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_subcategoria, nombre_sub, descripcion_sub, imagen, nombre_categoria
                FROM subcategorias
                INNER JOIN categorias USING(id_categoria)
                ORDER BY nombre_sub';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_subcategoria, nombre_sub, descripcion_sub, imagen, nombre_categoria
                FROM subcategorias
                INNER JOIN categorias USING(id_categoria)
                WHERE id_subcategoria = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE subcategorias
                SET id_subcategoria=?, nombre_sub=?, descripcion_sub=?, imagen=?, id_categoria=?
                WHERE id_subcategoria=?;';
        $params = array($this->imagen, $this->nombre, $this->descripcion, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM subcategorias
                WHERE id_subcategoria = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readCategorias()
    {
        $sql = 'SELECT id_categoria, nombre_categoria, descripcion_categoria
                FROM categorias';
            return Database::getRows($sql);
    }
}