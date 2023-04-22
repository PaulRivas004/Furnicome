<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad PRODUCTO.
*/
class UsuarioQueries
{
    /*
    *   Métodos para gestionar la cuenta del usuario.
    */
    public function checkUser($alias_usuario)
    {
        $sql = 'SELECT id_usuario FROM usuarios WHERE alias_usuario = ?';
        $params = array($alias_usuario);
        if ($data = Database::getRow($sql, $params)) {
            $this->id_usuario = $data['id_usuario'];
            $this->alias_usuario = $alias_usuario;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuarios WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['clave_usuario'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuarios SET clave_usuario = ? WHERE id_usuario = ?';
        $params = array($this->clave_usuario, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuarios
                SET nombre_usuario = ?, apellido_usuario = ?, correo_usuario = ?, alias_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre_usuario, $this->apellido_usuario, $this->correo_usuario, $this->alias_usuario, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario
                FROM usuarios
                WHERE apellido_usuario ILIKE ? OR nombre_usuario ILIKE ?
                ORDER BY apellido_usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(
            nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario)
            VALUES ( ?, ?, ?, ?, ?)';
        $params = array($this->nombre_usuario, $this->apellido_usuario, $this->correo_usuario, $this->alias_usuario, $this->clave_usuario);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario
                FROM usuarios
                ORDER BY id_usuario ASC';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuarios 
                SET nombre_usuario = ?, apellido_usuario = ?, correo_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombre_usuario, $this->apellido_usuario, $this->correo_usuario, $this->id_usuario);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id_usuario);
        return Database::executeRow($sql, $params);
    }
}
