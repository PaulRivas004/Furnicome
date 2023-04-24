<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class ProductoQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    public function createRow()
    {
        $sql = 'INSERT INTO productos( id_subcategoria, id_usuario, nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, existencia_producto)
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->id_subcategoria, $this->id_usuario, $this->nombre_producto, $this->descripcion_producto, $this->precio_producto, $this->imagen_producto, $this ->estado_producto, $this->existencia_producto);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT *
        FROM productos INNER JOIN subcategorias USING(id_subcategoria)
        INNER JOIN usuarios USING(id_usuario)
        ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT *
                FROM productos
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen_producto) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE productos
                SET id_subcategoria = ?, id_usuario = ?, nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, imagen_producto = ?, estado_producto = ?, existencia_producto = ?
                WHERE id_producto = ?';
        $params = array($this->id_subcategoria, $this->id_usuario, $this->nombre_producto, $this->descripcion_producto, $this->precio_producto, $this ->imagen_producto, $this->estado_producto, $this->existencia_producto, $this->id_producto);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::executeRow($sql, $params);
    }

    public function readSub(){
        $sql = 'SELECT id_subcategoria, nombre_sub, descripcion_sub, imagen, id_categoria
                FROM subcategorias';
        return Database::getRows($sql);
    }

    public function cargarUsuario(){
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario
                FROM usuarios';
        return Database::getRows($sql);
    }
}
