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

    public function readAll()
    {
        $sql = 'SELECT id_pedido, nombre_cliente, estado_pedido, fecha_pedido, direccion_pedido
                FROM pedidos INNER JOIN clientes USING(id_cliente)
                ORDER BY id_pedido ASC';
        return Database::getRows($sql);
    }

   
}
