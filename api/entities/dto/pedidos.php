<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedidos_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad Pedidos.
*/
class Pedidos extends PedidosQueries
{
    // Declaración de atributos (propiedades).
    protected $id_pedido = null;
    protected $id_cliente = null;
    protected $estado_pedido = null;
    protected $fecha_pedido = null;
    protected $direccion_pedido = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFecha($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 60)) {
            $this->direccion_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */

    public function getId()
    {
        return $this->id_pedido;
    }

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function getEstado()
    {
        return $this->estado_pedido;
    }

    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    public function getDireccion()
    {
        return $this->direccion_pedido;
    }
}
