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

    public function readAllPedidosTrue()
    {
        $sql = 'SELECT id_pedido, estado_pedido, fecha_pedido, direccion_pedido
                FROM pedidos INNER JOIN clientes USING(id_cliente)
                WHERE estado_pedido = 1
                ORDER BY id_pedido ASC';
        return Database::getRows($sql);
    }

    public function readAllPedidosProces()
    {
        $sql = 'SELECT id_pedido, estado_pedido, fecha_pedido, direccion_pedido
                FROM pedidos INNER JOIN clientes USING(id_cliente)
                WHERE estado_pedido = false
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
                WHERE id_pedido = ?';
        $params = array($this->id_pedido);
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


    // Método para verificar si existe un pedido en proceso para seguir comprando, de lo contrario se crea uno.
    public function startOrder()
    {
        $sql = 'SELECT id_pedido
                FROM pedidos
                WHERE estado_pedido = 0 AND id_cliente = ?';
        $params = array($_SESSION['id_cliente']);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_pedido = $data['id_pedido'];
            return true;
        } else {
            $sql = 'INSERT INTO pedidos(direccion_pedido, id_cliente)
                    VALUES((SELECT direccion_cliente FROM clientes WHERE id_cliente = ?), ?)';
            $params = array($_SESSION['id_cliente'], $_SESSION['id_cliente']);
            // Se obtiene el ultimo valor insertado en la llave primaria de la tabla pedidos.
            if ($this->id_pedido = Database::getLastRow($sql, $params)) {
                return true;
            } else {
                return false;
            }
        }
    }

     // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
         // Se realiza una subconsulta para obtener el precio del producto.
        $sql = 'INSERT INTO detalle_pedidos(id_pedido, id_producto, cantidad_producto, precio_producto)
                VALUES(?, ?, ?, (SELECT precio_producto FROM productos WHERE id_producto = ?))';
        $params = array($this->id_pedido, $this->id_producto, $this->cantidad_producto, $this->id_producto);
        return Database::executeRow($sql, $params);
    }

     // Método para obtener los productos que se encuentran en el carrito de compras.
    public function readOrderDetail()
    {
        $sql = 'SELECT id_detalle, nombre_producto, detalle_pedidos.precio_producto, detalle_pedidos.cantidad_producto
        FROM pedidos INNER JOIN detalle_pedidos USING(id_pedido) INNER JOIN productos USING(id_producto)
        WHERE id_pedido = ?';
        $params = array($this->id_pedido);
        return Database::getRows($sql, $params);
    }

     // Método para finalizar un pedido por parte del cliente.
    public function finishOrder()
    {
         // Se establece la zona horaria local para obtener la fecha del servidor.
        date_default_timezone_set('America/El_Salvador');
        $date = date('Y-m-d');
        $this->estado = 1;
        $sql = 'UPDATE pedidos
                SET estado_pedido = ?, fecha_pedido = ?
                WHERE id_pedido = ?';
        $params = array($this->estado, $date, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

     // Método para actualizar la cantidad de un producto agregado al carrito de compras.
    public function updateDetail()
    {
        $sql = 'UPDATE detalle_pedidos
                SET cantidad_producto = ?
                WHERE id_detalle = ? AND id_pedido = ?';
        $params = array($this->cantidad_producto, $this->id_detalle, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }

     // Método para eliminar un producto que se encuentra en el carrito de compras.
    public function deleteDetail()
    {
        $sql = 'DELETE FROM detalle_pedidos
                WHERE id_detalle = ? AND id_pedido = ?';
        $params = array($this->id_detalle, $_SESSION['id_pedido']);
        return Database::executeRow($sql, $params);
    }



    //SELECT id_detalle, nombre_producto, detalle_pedidos.precio_producto, detalle_pedidos.cantidad_producto
    //FROM pedidos INNER JOIN detalle_pedidos USING(id_pedido) INNER JOIN productos USING(id_producto)
    //WHERE id_cliente = 1 AND estado_pedido = true;

}


