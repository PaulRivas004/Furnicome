<?php
require_once('../../entities/dto/categoria.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $categoria = new Categoria;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'exception' => null, 'dataset' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['id_usuario'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readAll':
                //se hace la consulta a la base por medio de parametros de la querie para llenado de la tabla
                if ($result['dataset'] = $categoria->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen '.count($result['dataset']).' registros';
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'No hay datos registrados';
                }
                break;
                // Acción para crear un dato en la tabla de categorías
            case 'create':
                $_POST = Validator::validateForm($_POST);
                if (!$categoria->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$categoria->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif ($categoria->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Categoría creada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
                //Selecccionar un registro por medio de consultas en las queries accionado por un onUpdate
            case 'readOne':
                if (!$categoria->setId($_POST['id_categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif ($result['dataset'] = $categoria->readOne()) {
                    $result['status'] = 1;
                } elseif (Database::getException()) {
                    $result['exception'] = Database::getException();
                } else {
                    $result['exception'] = 'Categoría inexistente';
                }
                break;
                // Acción para actualizar un dato en la tabla categorías
            case 'update':
                $_POST = Validator::validateForm($_POST);
                if (!$categoria->setId($_POST['id'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$data = $categoria->readOne()) {
                    $result['exception'] = 'Categoría inexistente';
                } elseif (!$categoria->setNombre($_POST['nombre'])) {
                    $result['exception'] = 'Nombre incorrecto';
                } elseif (!$categoria->setDescripcion($_POST['descripcion'])) {
                    $result['exception'] = 'Descripción incorrecta';
                } elseif ($categoria->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Categoría modificada correctamente';
                    } else {
                        $result['exception'] = Database::getException();
                    }
                break;
                // Acción para eliminar un dato de la tabla categorías
            case 'delete':
                if (!$categoria->setId($_POST['id_categoria'])) {
                    $result['exception'] = 'Categoría incorrecta';
                } elseif (!$data = $categoria->readOne()) {
                    $result['exception'] = 'Categoría inexistente';
                } elseif ($categoria->deleteRow()) {
                    $result['status'] = 1;                   
                    $result['message'] = 'Categoría eliminada correctamente';
                } else {
                    $result['exception'] = Database::getException();
                }
                break;
            default:
                $result['exception'] = 'Acción no disponible dentro de la sesión';
        }
        // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
        header('content-type: application/json; charset=utf-8');
        // Se imprime el resultado en formato JSON y se retorna al controlador.
        print(json_encode($result));
    } else {
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}
