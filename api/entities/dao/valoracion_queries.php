<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CATEGORIA.
*/
class ValoracionesQueries
{
    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function createRow()
    {
        $sql = 'INSERT INTO valoraciones(
            id_valoracion, id_detalle, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario)
            VALUES (?, ?, ?, ?, ?, ?)';
        $params = array($this->detalle, $this->calificacion, $this->comentario, $this->fecha, $this->estado);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_valoracion, nombre_producto, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
            FROM valoraciones
            INNER JOIN detalle_pedidos USING (id_detalle)
            INNER JOIN productos USING (id_producto)
                ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_valoracion, id_detalle, calificacion_producto, comentario_producto, fecha_comentario, estado_comentario
                FROM valoraciones      
                WHERE id_valoracion = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE valoraciones
                SET id_detalle=?, calificacion_producto=?, comentario_producto=?, fecha_comentario=?, estado_comentario=?
                WHERE id_valoracion = ?';
        $params = array($this->detalle, $this->calificacion, $this->comentario, $this->fecha, $this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM valoraciones
                WHERE id_valoracion = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function readDetalle()
    {
        $sql = 'SELECT id_detalle, id_pedido, nombre_producto, cantidad_producto, precio_producto
        FROM detalle_pedidos';
        return Database::getRows($sql);
    }
}
