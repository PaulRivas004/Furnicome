<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/usuario_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad PRODUCTO.
*/
class Usuario extends UsuarioQueries
{
    // Declaración de atributos (propiedades).
    protected $id_usuario = null;
    protected $nombre_usuario = null;
    protected $apellido_usuario = null;
    protected $alias_usuario = null;
    protected $correo_usuario = null;
    protected $clave_usuario = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombres($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 60)) {
            $this->nombre_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidos($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 60)) {
            $this->apellido_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if (Validator::validateString($value, 1, 40)) {
            $this->clave_usuario= password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    public function setAlias($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->alias_usuario = $value;
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
        return $this->id_usuario;
    }

    public function getNombres()
    {
        return $this->nombre_usuario;
    }

    public function getApellidos()
    {
        return $this->apellido_usuario;
    }

    public function getCorreo()
    {
        return $this->correo_usuario;
    }

    public function getClave()
    {
        return $this->clave_usuario;
    }

    public function getAlias()
    {
        return $this->alias_usuario;
    }

}
