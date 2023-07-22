<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class CategoriaQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */


    //Método par insertar datos a la tabla de categorias 
    public function createRow()
    {
        $sql = 'INSERT INTO categorias(nombre_categoria, descripcion_categoria)
                VALUES(?, ?)';
        $params = array($this->nombre, $this->descripcion);
        return Database::executeRow($sql, $params);
    }

    //Método para leer todos los registros de la tabla, ordenados por el nombre de la categoría
    public function readAll()
    {
        $sql = 'SELECT id_categoria, nombre_categoria, descripcion_categoria
                FROM categorias
                ORDER BY nombre_categoria';
        return Database::getRows($sql);
    }

    //Método para consultar datos de una columna específica por medio de un parametro del id
    public function readOne()
    {
        $sql = 'SELECT id_categoria, nombre_categoria, descripcion_categoria
                FROM categorias
                WHERE id_categoria = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    //Método para realizar la actualización de la tabla por medio de una query parametrizada
    public function updateRow()
    {
        $sql = 'UPDATE categorias
                SET nombre_categoria = ?, descripcion_categoria = ?
                WHERE id_categoria = ?';
        $params = array($this->nombre, $this->descripcion, $this->id);
        return Database::executeRow($sql, $params);
    }

  //Metodo para eliminar un dato de la tabla por medio del id
    public function deleteRow()
    {
        $sql = 'DELETE FROM categorias
                WHERE id_categoria = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readSubXCategorias()
    {
        $sql = 'SELECT categorias.nombre_categoria, GROUP_CONCAT(subcategorias.nombre_sub) AS subcategorias
        FROM categorias
        LEFT JOIN subcategorias ON categorias.id_categoria = subcategorias.id_categoria
        GROUP BY categorias.nombre_categoria
        ORDER BY categorias.nombre_categoria;
        ';
            return Database::getRows($sql);
    }
}
