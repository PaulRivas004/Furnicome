<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/producto_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Producto extends ProductoQueries
{
    // Declaración de atributos (propiedades).
    protected $id_producto = null;
    protected $id_usuario = null;
    protected $id_subcategoria = null;
    protected $nombre_producto = null;
    protected $descripcion_producto = null;
    protected $precio_producto = null;
    protected $imagen_producto = null;
    protected $existencia_producto = null;
    protected $estado_producto = null;
    protected $ruta = '../../images/productos/';

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdUsu($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setIdSubCategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombre_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->descripcion_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->imagen_producto = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setExistencia($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->existencia_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_producto = $value;
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
        return $this->id_producto;
    }

    public function getIdUsu()
    {
        return $this->id_usuario;
    }

    public function getIdSubCategoria()
    {
        return $this->id_subcategoria;
    }

    public function getNombre()
    {
        return $this->nombre_producto;
    }

    public function getDescripcion()
    {
        return $this->descripcion_producto;
    }

    public function getPrecio()
    {
        return $this->precio_producto;
    }

    public function getImagen()
    {
        return $this->imagen_producto;
    }

    public function getExistencia()
    {
        return $this->existencia_producto;
    }

    public function getEstado()
    {
        return $this->estado_producto;
    }

    public function getRuta()
    {
        return $this->ruta;
    }
}
