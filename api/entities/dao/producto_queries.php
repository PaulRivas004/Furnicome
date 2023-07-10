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

    //Método para consultar datos a la tabla de productos por medio de una query 
    public function searchRows($value)
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, descripcion_producto, precio_producto, nombre_categoria, estado_producto
                FROM producto INNER JOIN categorias USING(id_categoria)
                WHERE nombre_producto ILIKE ? OR descripcion_producto ILIKE ?
                ORDER BY nombre_producto';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
    
    //Método para insertar datos a la tabla de productos por medio de una query 
    public function createRow()
    {
        $sql = 'INSERT INTO productos( id_subcategoria, id_usuario, nombre_producto, descripcion_producto, precio_producto, imagen_producto, estado_producto, existencia_producto)
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->id_subcategoria, $this->id_usuario, $this->nombre_producto, $this->descripcion_producto, $this->precio_producto, $this->imagen_producto, $this->estado_producto, $this->existencia_producto);
        return Database::executeRow($sql, $params);
    }

    //Método para leer los registros de la tabla ordenandolos por sus apellidos por medio de una query general a la tabla
    public function readAll()
    {
        $sql = 'SELECT *
        FROM productos INNER JOIN subcategorias USING(id_subcategoria)
        INNER JOIN usuarios USING(id_usuario)
        ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    //Método para consultar una columna específica de la tabla por medio de su id
    public function readOne()
    {
        $sql = 'SELECT *
                FROM productos
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::getRow($sql, $params);
    }

    //Método para realizar la actualización de la tabla por medio de una query parametrizada
    public function updateRow($current_image)
    {
        // Se verifica si existe una nueva imagen para borrar la actual, de lo contrario se mantiene la actual.
        ($this->imagen_producto) ? Validator::deleteFile($this->getRuta(), $current_image) : $this->imagen = $current_image;

        $sql = 'UPDATE productos
                SET id_subcategoria = ?, id_usuario = ?, nombre_producto = ?, descripcion_producto = ?, precio_producto = ?, imagen_producto = ?, estado_producto = ?, existencia_producto = ?
                WHERE id_producto = ?';
        $params = array($this->id_subcategoria, $this->id_usuario, $this->nombre_producto, $this->descripcion_producto, $this->precio_producto, $this->imagen_producto, $this->estado_producto, $this->existencia_producto, $this->id_producto);
        return Database::executeRow($sql, $params);
    }

       //Metodo para eliminar un dato de la tabla por medio del id
    public function deleteRow()
    {
        $sql = 'DELETE FROM productos
                WHERE id_producto = ?';
        $params = array($this->id_producto);
        return Database::executeRow($sql, $params);
    }


    //Método para leer la subcategoria por medio de una query
    public function readSub()
    {

        $sql = 'SELECT id_subcategoria, nombre_sub, descripcion_sub, imagen, id_categoria
                FROM subcategorias';
        return Database::getRows($sql);
    }

    //Método para cargar el usuario que insertó el producto
    public function cargarUsuario()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario
                FROM usuarios';
        return Database::getRows($sql);
    }
    //Método para cargar el usuario que insertó el producto
    public function readproductosSubCategoria()
    {
        $sql = 'SELECT id_producto, imagen_producto, nombre_producto, precio_producto
        FROM productos INNER JOIN subcategorias USING(id_subcategoria)
        WHERE estado_producto = true
        ORDER BY nombre_producto';
        return Database::getRows($sql);
    }
}
