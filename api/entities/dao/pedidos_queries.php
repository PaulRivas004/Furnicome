<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class PedidosQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */

    //Método para leer los registros de la tabla ordenándolos por sus id
    public function readAll()
    {
        $sql = 'SELECT id_pedido, nombre_cliente, estado_pedido, fecha_pedido, direccion_pedido
                FROM pedidos INNER JOIN clientes USING(id_cliente)
                ORDER BY id_pedido ASC';
        return Database::getRows($sql);
    }

    //Método para consultar una columna específica de la tabla por medio de su id
    public function readOne()
    {
        $sql = 'SELECT id_pedido, nombre_cliente, estado_pedido, fecha_pedido, direccion_pedido
                FROM pedidos INNER JOIN clientes USING(id_cliente)
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRow($sql, $params);
    }

    //Método para consultar a la tabla detalle_pedido y llenar el select de los detalles del pedido
    public function readDetail()
    {
        $sql = 'SELECT id_detalle, id_pedido, nombre_producto, cantidad_producto
                FROM detalle_pedidos INNER JOIN productos USING(id_producto)
                WHERE id_detalle = ?';
        $params = array($this->id_detalle);
        return Database::getRows($sql, $params);
    }

    //Método para realizar la actualización del estado del pedido por medio de una query parametrizada
    public function updateRow()
    {
        $sql = 'UPDATE pedidos 
                SET estado_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado_pedido, $this->id_pedido);
        return Database::executeRow($sql, $params);
    }

    //Metodo para eliminar un dato de la tabla por medio de un id específico
    public function deleteRow()
    {
        $sql = 'DELETE FROM pedidos
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::executeRow($sql, $params);
    }

   
}
