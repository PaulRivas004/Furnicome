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
        $params = array($this->id_subcategoria, $this->id_usuario, $this->nombre_producto, $this->descripcion_producto, $this->precio_producto, $this->imagen_producto, $this ->estado_producto, $this->existencia_producto, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, imagen_producto,nombre_usuario, nombre_producto, descripcion_producto, precio_producto, nombre_sub, estado_producto, existencia_producto
        FROM productos INNER JOIN subcategorias USING(id_subcategoria)
        INNER JOIN usuarios USING(id_usuario)
        ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, descripcion_producto, precio_producto, imagen_producto, id_categoria, estado_producto
                FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE productos
                SET imagen_producto = ?, nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, estado_producto = ?, id_categoria = ?
                WHERE id_producto = ?';
        $params = array($this->imagen, $this->nombre, $this->descripcion, $this->precio, $this->estado, $this->categoria, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

 
}
